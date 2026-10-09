@extends('layouts.app')

@section('title', 'Status Antrian')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Status Antrian</h1>
            <p class="mt-2 text-gray-600">{{ $schedule->title }} - {{ $schedule->location }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistik Antrian -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $queues->where('status', 'completed')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h2a1 1 0 100-2 2 2 0 00-2 2v11a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v11zm8 8v1h2v-1h-2zm-2 0v1h2v-1h-2zm-2 0v1h2v-1H8zm2-4v1h2V9h-2zm-2 0v1h2V9H8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $queues->where('status', 'waiting')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Dipanggil</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $queues->where('status', 'called')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Dilayani</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $queues->where('status', 'serving')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Status -->
        @if($queues->where('status', 'serving')->isNotEmpty())
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-blue-900 mb-4">Sedang Dilayani</h3>
                @foreach($queues->where('status', 'serving') as $queue)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-600 font-semibold">#{{ $queue->queue_number }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-blue-900">{{ $queue->registration->user->nama_lengkap }}</p>
                                <p class="text-blue-700 text-sm">Mulai pada {{ $queue->serving_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Antrian Anda -->
        @auth
            @php
                $myQueue = $queues->where('registration.user_id', auth()->id())->first();
            @endphp
            @if($myQueue)
                <div class="bg-white shadow rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Antrian Anda</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 @if($myQueue->status == 'completed') bg-green-100 @elseif($myQueue->status == 'serving' || $myQueue->status == 'failed') bg-red-100 @elseif($myQueue->status == 'called') bg-blue-100 @elseif($myQueue->status == 'preparing') bg-yellow-100 @elseif($myQueue->status == 'skipped') bg-orange-100 @else bg-gray-100 @endif rounded-full flex items-center justify-center mr-4">
                                <span class="@if($myQueue->status == 'completed') text-green-600 @elseif($myQueue->status == 'serving' || $myQueue->status == 'failed') text-red-600 @elseif($myQueue->status == 'called') text-blue-600 @elseif($myQueue->status == 'preparing') text-yellow-600 @elseif($myQueue->status == 'skipped') text-orange-600 @else text-gray-600 @endif font-bold text-lg">#{{ $myQueue->queue_number }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Status: 
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($myQueue->status == 'completed') bg-green-100 text-green-800
                                        @elseif($myQueue->status == 'serving') bg-red-100 text-red-800
                                        @elseif($myQueue->status == 'called') bg-blue-100 text-blue-800
                                        @elseif($myQueue->status == 'preparing') bg-yellow-100 text-yellow-800
                                        @elseif($myQueue->status == 'skipped') bg-orange-100 text-orange-800
                                        @elseif($myQueue->status == 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ match($myQueue->status) {
                                            'waiting' => 'Menunggu',
                                            'preparing' => 'Bersiap',
                                            'called' => 'Dipanggil',
                                            'serving' => 'Dilayani',
                                            'completed' => 'Selesai',
                                            'skipped' => 'Skipped',
                                            'failed' => 'Gagal Donor',
                                            default => $myQueue->status
                                        } }}
                                    </span>
                                </p>
                                @if($myQueue->called_at)
                                    <p class="text-sm text-gray-500">Dipanggil pada {{ $myQueue->called_at->format('H:i') }}</p>
                                @endif
                                @if($myQueue->serving_at)
                                    <p class="text-sm text-gray-500">Mulai pada {{ $myQueue->serving_at->format('H:i') }}</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($myQueue->registration && $myQueue->registration->eTicket)
                            <a href="{{ route('donor.eticket.show', $myQueue->registration) }}" 
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                                Lihat E-Ticket
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @endauth

        <!-- Daftar Antrian -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Antrian</h3>
                
                @if($queues->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($queues->sortBy('queue_number') as $queue)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                #{{ $queue->queue_number }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $queue->registration->user->nama_lengkap }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($queue->status == 'completed') bg-green-100 text-green-800
                                                @elseif($queue->status == 'serving') bg-red-100 text-red-800
                                                @elseif($queue->status == 'called') bg-blue-100 text-blue-800
                                                @elseif($queue->status == 'preparing') bg-yellow-100 text-yellow-800
                                                @elseif($queue->status == 'skipped') bg-orange-100 text-orange-800
                                                @elseif($queue->status == 'failed') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ match($queue->status) {
                                                    'waiting' => 'Menunggu',
                                                    'preparing' => 'Bersiap',
                                                    'called' => 'Dipanggil',
                                                    'serving' => 'Dilayani',
                                                    'completed' => 'Selesai',
                                                    'skipped' => 'Skipped',
                                                    'failed' => 'Gagal Donor',
                                                    default => $queue->status
                                                } }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($queue->status === 'waiting')
                                                <span class="text-gray-400">-</span>
                                            @elseif($queue->status === 'completed' && $queue->completed_at)
                                                Selesai: {{ $queue->completed_at->format('H:i') }}
                                            @else
                                                @if($queue->called_at)
                                                    Dipanggil: {{ $queue->called_at->format('H:i') }}
                                                @endif
                                                @if($queue->serving_at)
                                                    <br>Dilayani: {{ $queue->serving_at->format('H:i') }}
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h2a1 1 0 100-2 2 2 0 00-2 2v11a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v11zm8 8v1h2v-1h-2zm-2 0v1h2v-1h-2zm-2 0v1h2v-1H8zm2-4v1h2V9h-2zm-2 0v1h2V9H8z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada antrean</h3>
                        <p class="mt-1 text-sm text-gray-500">Antrean akan muncul ketika pendonor mendaftar.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
