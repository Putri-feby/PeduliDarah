@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Pendaftaran Saya</h1>
        <p class="text-gray-600">Lihat dan kelola pendaftaran donor darah Anda</p>
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

        @if($registrations->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($registrations as $registration)
                        <li class="p-4 sm:p-6 hover:bg-gray-50">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @if($registration->status == 'completed')
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @elseif($registration->status == 'confirmed')
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-base sm:text-lg font-medium text-gray-900">
                                                {{ $registration->schedule->title }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $registration->schedule->location }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $registration->schedule->start_time->format('D, M j, Y - H:i') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid grid-cols-1 sm:flex sm:items-center sm:space-x-6 gap-3">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500">Status:</span>
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($registration->status == 'completed') bg-green-100 text-green-800
                                                @elseif($registration->status == 'confirmed') bg-blue-100 text-blue-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </div>

                                        @if($registration->queue)
                                            <div class="flex items-center">
                                                <span class="text-sm font-medium text-gray-500">Antrean:</span>
                                                <span class="ml-2 text-sm text-gray-900">#{{ $registration->queue->queue_number }}</span>
                                            </div>
                                        @endif

                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500">Terdaftar:</span>
                                            <span class="ml-2 text-sm text-gray-900">
                                                {{ $registration->registration_time->format('M j, Y H:i') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($registration->notes)
                                        <div class="mt-2">
                                            <span class="text-sm font-medium text-gray-500">Catatan:</span>
                                            <p class="mt-1 text-sm text-gray-900">{{ $registration->notes }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-row sm:flex-col items-center space-x-2 sm:space-x-0 sm:space-y-2 mt-4 sm:mt-0">
                                    @if($registration->eTicket)
                                        <a href="{{ route('donor.eticket.show', $registration) }}"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full sm:w-auto justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                            </svg>
                                            Lihat E-Ticket
                                        </a>
                                    @endif

                                    @if($registration->schedule->start_time->isFuture() && $registration->status != 'completed')
                                        <a href="{{ route('donor.queue.show', $registration->schedule) }}"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full sm:w-auto justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h2a1 1 0 100-2 2 2 0 00-2 2v11a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v11zm8 8v1h2v-1h-2zm-2 0v1h2v-1h-2zm-2 0v1h2v-1H8zm2-4v1h2V9h-2zm-2 0v1h2V9H8z" clip-rule="evenodd"></path>
                                            </svg>
                                            Lihat Antrean
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100-4h2a1 1 0 100-2 2 2 0 00-2 2v11a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v11zm8 8v1h2v-1h-2zm-2 0v1h2v-1h-2zm-2 0v1h2v-1H8zm2-4v1h2V9h-2zm-2 0v1h2V9H8z" clip-rule="evenodd"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pendaftaran</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan mendaftar jadwal donor darah.</p>
                <div class="mt-6">
                    <a href="{{ route('donor.schedules.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Lihat Jadwal Tersedia
                    </a>
                </div>
            </div>
        @endif
</div>
@endsection
