<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\DonationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QueueController extends Controller
{
    public function show(DonationSchedule $schedule)
    {
        $queues = Queue::where('schedule_id', $schedule->id)
            ->with('registration.user')
            ->orderBy('queue_number')
            ->get();
            
        $currentQueue = Queue::where('schedule_id', $schedule->id)
            ->whereIn('status', ['called', 'serving'])
            ->first();
            
        return view('donor.queue', compact('schedule', 'queues', 'currentQueue'));
    }

    public function manage(DonationSchedule $schedule)
    {
        if ($schedule->pmi_id !== auth()->user()->pmi_id) {
            abort(403, 'Unauthorized');
        }

        $queues = Queue::where('schedule_id', $schedule->id)
            ->with('registration.user')
            ->orderBy('queue_number')
            ->get();

        $currentQueue = Queue::where('schedule_id', $schedule->id)
            ->whereIn('status', ['called', 'serving'])
            ->first();

        return view('admin.queue', compact('schedule', 'queues', 'currentQueue'));
    }

    private function sendNotification($user, $message, $heading)
    {
        if (!$user) return;
        
        $user->notify(new \App\Notifications\GenericQueueNotification($message, $heading));

        if (env('ONESIGNAL_APP_ID') && env('ONESIGNAL_REST_API_KEY')) {
            try {
                Http::withHeaders([
                    'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                ])->post('https://onesignal.com/api/v1/notifications', [
                    'app_id' => env('ONESIGNAL_APP_ID'),
                    'target_channel' => 'push',
                    'include_aliases' => [
                        'external_id' => [strval($user->id)]
                    ],
                    'contents' => [
                        'en' => $message,
                        'id' => $message
                    ],
                    'headings' => [
                        'en' => $heading,
                        'id' => $heading
                    ]
                ]);
            } catch (\Exception $e) {
                \Log::error('OneSignal Error: ' . $e->getMessage());
            }
        }
    }

    private function advanceQueue(DonationSchedule $schedule)
    {
        // Next donor to call
        $nextToCall = Queue::where('schedule_id', $schedule->id)
            ->whereIn('status', ['preparing', 'waiting'])
            ->orderBy('queue_number', 'asc')
            ->first();

        if ($nextToCall) {
            $nextToCall->update([
                'status' => 'called',
                'called_at' => now(),
            ]);
            
            if ($nextToCall->registration && $nextToCall->registration->user) {
                $this->sendNotification(
                    $nextToCall->registration->user,
                    "Silakan menuju ruang donor darah.",
                    "Panggilan Antrean"
                );
            }

            // Next donor to prepare
            $nextToPrepare = Queue::where('schedule_id', $schedule->id)
                ->where('status', 'waiting')
                ->where('id', '!=', $nextToCall->id)
                ->orderBy('queue_number', 'asc')
                ->first();

            if ($nextToPrepare) {
                $nextToPrepare->update(['status' => 'preparing']);
                if ($nextToPrepare->registration && $nextToPrepare->registration->user) {
                    $this->sendNotification(
                        $nextToPrepare->registration->user,
                        "Giliran Anda berikutnya. Mohon bersiap di dekat ruang donor.",
                        "Persiapan Antrean"
                    );
                }
            }
        }
    }

    public function call(Queue $queue)
    {
        if ($queue->schedule->status !== 'ongoing') {
            return back()->with('error', 'Antrean hanya dapat dipanggil saat jadwal sedang berlangsung.');
        }

        if ($queue->status !== 'waiting' && $queue->status !== 'preparing' && $queue->status !== 'skipped') {
            return back()->with('error', 'Antrean ini sudah dipanggil atau selesai.');
        }

        $isRecall = ($queue->status === 'skipped');

        $queue->update([
            'status' => 'called',
            'called_at' => now(),
        ]);

        if ($queue->registration && $queue->registration->user) {
            $this->sendNotification(
                $queue->registration->user,
                "Silakan menuju ruang donor darah.",
                "Panggilan Antrean"
            );
        }

        if (!$isRecall) {

        // Prepare the next person
        $next1 = Queue::where('schedule_id', $queue->schedule_id)
            ->where('status', 'waiting')
            ->orderBy('queue_number', 'asc')
            ->first();

        if ($next1) {
            $next1->update(['status' => 'preparing']);
            if ($next1->registration && $next1->registration->user) {
                $this->sendNotification(
                    $next1->registration->user,
                    "Giliran Anda berikutnya. Mohon bersiap di dekat ruang donor.",
                    "Persiapan Antrean"
                );
            }
            
            // Notify the 3rd person
            $next2 = Queue::where('schedule_id', $queue->schedule_id)
                ->where('status', 'waiting')
                ->where('id', '!=', $next1->id)
                ->orderBy('queue_number', 'asc')
                ->first();

            if ($next2 && $next2->registration && $next2->registration->user) {
                $this->sendNotification(
                    $next2->registration->user,
                    "Mohon menunggu. Antrean Anda akan segera dipanggil.",
                    "Informasi Antrean"
                );
            }
        }
        }

        return back()->with('success', 'Antrean nomor ' . $queue->queue_number . ' telah dipanggil.');
    }

    public function complete(Queue $queue)
    {
        if (!in_array($queue->status, ['called', 'serving'])) {
            return back()->with('error', 'Antrean ini sedang tidak dilayani atau dipanggil.');
        }

        $queue->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        if ($queue->registration) {
            $queue->registration->update(['status' => 'completed']);
        }

        $this->advanceQueue($queue->schedule);

        return back()->with('success', 'Antrean nomor ' . $queue->queue_number . ' telah selesai dilayani.');
    }

    public function skip(Queue $queue)
    {
        if ($queue->status !== 'called') {
            return back()->with('error', 'Hanya antrean yang dipanggil yang dapat di-skip.');
        }

        $queue->update([
            'status' => 'skipped',
        ]);
        
        if ($queue->registration && $queue->registration->user) {
            $this->sendNotification(
                $queue->registration->user,
                "Anda telah melewati panggilan antrean. Silakan hubungi petugas apabila masih berada di lokasi.",
                "Panggilan Terlewat"
            );
        }

        $this->advanceQueue($queue->schedule);

        return back()->with('success', 'Antrean nomor ' . $queue->queue_number . ' telah di-skip.');
    }

    public function serve(Queue $queue)
    {
        if ($queue->schedule->status !== 'ongoing') {
            return back()->with('error', 'Antrean hanya dapat dilayani saat jadwal sedang berlangsung.');
        }

        if ($queue->status !== 'called') {
            return back()->with('error', 'Antrean ini harus dipanggil terlebih dahulu.');
        }

        $queue->update([
            'status' => 'serving',
            'serving_at' => now(),
        ]);

        return back()->with('success', 'Antrean nomor ' . $queue->queue_number . ' sedang dilayani.');
    }

    public function getQueueStatus(DonationSchedule $schedule)
    {
        $queues = Queue::where('schedule_id', $schedule->id)
            ->with('registration.user')
            ->orderBy('queue_number')
            ->get();
            
        $currentQueue = Queue::where('schedule_id', $schedule->id)
            ->whereIn('status', ['called', 'serving'])
            ->first();
            
        return response()->json([
            'queues' => $queues,
            'currentQueue' => $currentQueue,
            'waitingCount' => Queue::where('schedule_id', $schedule->id)->where('status', 'waiting')->count(),
        ]);
    }

    public function myActiveQueue()
    {
        if (!auth()->check()) return response()->json(['queue' => null]);
        
        $queue = Queue::whereHas('registration', function($q) {
            $q->where('user_id', auth()->id());
        })
        ->whereIn('status', ['called', 'serving'])
        ->with('schedule')
        ->first();
        
        return response()->json(['queue' => $queue]);
    }
}
