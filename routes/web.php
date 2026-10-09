<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationScheduleController;
use App\Http\Controllers\DonationRegistrationController;
use App\Http\Controllers\ETicketController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\CollaborationController;

use Illuminate\Http\Request;
use App\Models\User;

Route::post('/check-duplicates', function (Request $request) {
    $emailExists = $request->email ? User::where('email', $request->email)->exists() : false;
    $phoneExists = $request->no_telp ? User::where('no_telp', $request->no_telp)->exists() : false;
    $nikExists = $request->nik ? User::where('nik', $request->nik)->exists() : false;

    return response()->json([
        'email' => $emailExists,
        'no_telp' => $phoneExists,
        'nik' => $nikExists,
    ]);
});

Route::get('/', function () {
    $dest = public_path('images/gedung-pmi.png');
    @copy('C:/Users/User/.gemini/antigravity-ide/brain/b6849c1a-526a-4d7a-9f37-aaee14d7fc1b/media__1784296814746.png', $dest);
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin() ? redirect()->route('admin.schedules.index') : redirect()->route('donor.dashboard');
    })->name('dashboard');

    Route::get('/notifications/{id}/read', function ($id) {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return back();
    })->name('notifications.read');

    Route::get('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.readAll');
    
    Route::prefix('donor')->name('donor.')->group(function () {
        Route::get('/dashboard', [DonationRegistrationController::class, 'dashboard'])->name('dashboard');
        Route::get('/schedules', [DonationScheduleController::class, 'donorIndex'])->name('schedules.index');
        Route::post('/schedules/verify-invite', [DonationScheduleController::class, 'verifyInvite'])->name('schedules.verify-invite');
        Route::get('/register/{schedule}', [DonationRegistrationController::class, 'showRegistration'])->name('register.show');
        Route::post('/register/{schedule}', [DonationRegistrationController::class, 'register'])->name('register.schedule');
        Route::get('/my-registrations', [DonationRegistrationController::class, 'myRegistrations'])->name('registrations.index');
        Route::get('/eticket/{registration}', [ETicketController::class, 'show'])->name('eticket.show');
        Route::get('/queue/{schedule}', [QueueController::class, 'show'])->name('queue.show');
        Route::get('/collaborations', [CollaborationController::class, 'donorIndex'])->name('collaborations.index');
        Route::get('/tickets', [ETicketController::class, 'donorTicketsIndex'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [ETicketController::class, 'donorTicketShow'])->name('tickets.show');
        Route::get('/profile', [DonationRegistrationController::class, 'profile'])->name('profile');
        Route::get('/formulir-kuesioner/{registration}', [ETicketController::class, 'printFormulir'])->name('eticket.print-formulir');
    });
    
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

        Route::resource('schedules', DonationScheduleController::class)->except(['show']);
        Route::get('/registrations', [DonationRegistrationController::class, 'index'])->name('registrations.index');
        Route::put('/registrations/{registration}/confirm', [DonationRegistrationController::class, 'confirm'])->name('registrations.confirm');
        Route::get('/etickets', [ETicketController::class, 'index'])->name('etickets.index');
        Route::post('/etickets/{registration}/generate', [ETicketController::class, 'generate'])->name('etickets.generate');
        Route::post('/etickets/{eticket}/scan', [ETicketController::class, 'scan'])->name('etickets.scan');
        Route::get('/queue/{schedule}', [QueueController::class, 'manage'])->name('queue.manage');
        Route::post('/queue/{queue}/call', [QueueController::class, 'call'])->name('queue.call');
        Route::post('/queue/{queue}/serve', [QueueController::class, 'serve'])->name('queue.serve');
        Route::post('/queue/{queue}/complete', [QueueController::class, 'complete'])->name('queue.complete');
        Route::post('/queue/{queue}/skip', [QueueController::class, 'skip'])->name('queue.skip');
        Route::get('/collaborations/{collaboration}/print', [CollaborationController::class, 'print'])->name('collaborations.print');
        Route::resource('collaborations', CollaborationController::class);
        
        // Ticket scanning routes
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/scan', [ETicketController::class, 'scanInterface'])->name('scan');
            Route::post('/verify', [ETicketController::class, 'scanVerify'])->name('verify');
            Route::get('/history', [ETicketController::class, 'scanHistory'])->name('history');
            Route::get('/stats', [ETicketController::class, 'scanStats'])->name('stats');
        });
        
        // Debug route for testing
        Route::get('/registrations-debug', function() {
            $registrations = \App\Models\DonationRegistration::with('user', 'schedule')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('admin.daftar.regist.user', compact('registrations'));
        })->name('registrations.debug');
    });
});

Route::get('/collaborations', [CollaborationController::class, 'create'])->name('collaborations.create');
Route::post('/collaborations', [CollaborationController::class, 'store'])->name('collaborations.store');

// Donor collaboration routes
Route::prefix('donor')->name('donor.')->group(function () {
    Route::get('/collaboration-request', [CollaborationController::class, 'donorRequest'])->name('collaboration-request');
    Route::post('/collaboration-request', [CollaborationController::class, 'storeDonorRequest'])->name('collaboration-request.store');
    Route::get('/collaborations', [CollaborationController::class, 'donorIndex'])->name('collaborations');
    Route::get('/collaborations/{collaboration}', [CollaborationController::class, 'donorShow'])->name('collaborations.show');
    Route::delete('/collaborations/{collaboration}', [CollaborationController::class, 'donorDestroy'])->name('collaborations.destroy');
});

Route::get('/api/etickets/verify/{ticketCode}', [ETicketController::class, 'verify'])->name('etickets.verify');
Route::get('/api/queue/{schedule}', [QueueController::class, 'getQueueStatus'])->name('queue.status');
Route::get('/api/my-active-queue', [QueueController::class, 'myActiveQueue'])->name('api.queue.active');
