@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Tiket</h1>
                <p class="text-red-100">Informasi lengkap tiket donor darah Anda</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-ticket-alt text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Card -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
        <!-- Ticket Header -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 p-6">
            <div class="flex justify-between items-start">
                <div class="text-white">
                    <h2 class="text-2xl font-bold mb-2">{{ $ticket->registration->schedule->title }}</h2>
                    <p class="text-red-100">{{ $ticket->registration->schedule->location }}</p>
                </div>
                <div class="text-right">
                    <div class="bg-white text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $ticket->ticket_code }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Event Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Acara</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Tanggal:</span>
                            <span class="ml-2">{{ $ticket->registration->schedule->start_time->format('d F Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Waktu:</span>
                            <span class="ml-2">{{ $ticket->registration->schedule->start_time->format('H:i') }} - {{ $ticket->registration->schedule->end_time->format('H:i') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Lokasi:</span>
                            <span class="ml-2">{{ $ticket->registration->schedule->location }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                            <span class="font-medium">Antrian:</span>
                            <span class="ml-2">#{{ $ticket->registration->queue->queue_number ?? 'Belum ada' }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code</h3>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        @if($ticket->qr_code)
                            @if(str_contains(base64_decode($ticket->qr_code), '<svg'))
                                <!-- SVG QR Code -->
                                <div class="w-48 h-48 mx-auto mb-3">{!! base64_decode($ticket->qr_code) !!}</div>
                            @else
                                <!-- PNG QR Code -->
                                <img src="data:image/png;base64,{{ $ticket->qr_code }}" alt="QR Code" class="w-48 h-48 mx-auto mb-3">
                            @endif
                        @else
                            <div class="w-48 h-48 bg-gray-200 mx-auto mb-3 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd"></path>
                                    <path d="M11 4a1 1 0 10-2 0v1a1 1 0 002 0V4zM10 7a1 1 0 011 1v1h2a1 1 0 110 2h-3a1 1 0 01-1-1V8a1 1 0 011-1zM16 9a1 1 0 100 2 1 1 0 000-2zM9 13a1 1 0 011-1h1a1 1 0 110 2v2a1 1 0 11-2 0v-3zM7 11a1 1 0 100-2H4a1 1 0 00 0 2h3zM17 13a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM16 17a1 1 0 100-2h-3a1 1 0 100 2h3z"></path>
                                </svg>
                            </div>
                        @endif
                        <p class="text-sm text-gray-600">Scan QR code ini saat check-in</p>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Status Tiket</p>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            @if($ticket->status == 'generated') bg-green-100 text-green-800
                            @elseif($ticket->status == 'scanned') bg-blue-100 text-blue-800
                            @elseif($ticket->status == 'used') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $ticket->status == 'generated' ? 'Aktif' : 
                               ($ticket->status == 'scanned' ? 'Dipindai' : 
                               ($ticket->status == 'used' ? 'Digunakan' : 'Kadaluarsa')) }}
                        </span>
                    </div>

                    @if($ticket->expires_at)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">Kadaluarsa</p>
                            <p class="font-medium text-gray-900">{{ $ticket->expires_at->format('d F Y H:i') }}</p>
                            @if($ticket->expires_at->isPast())
                                <p class="text-sm text-red-600 mt-1">Tiket telah kadaluarsa</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registration Details -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pendaftaran</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Nama:</span>
                                <span class="ml-2">{{ $ticket->registration->user->nama_lengkap }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                <span class="font-medium">Email:</span>
                                <span class="ml-2">{{ $ticket->registration->user->email }}</span>
                            </div>
                            @if($ticket->registration->user->no_telp)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                    <span class="font-medium">Telepon:</span>
                                    <span class="ml-2">{{ $ticket->registration->user->no_telp }}</span>
                                </div>
                            @endif
                            @if($ticket->registration->notes)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-medium">Catatan:</span>
                                    <span class="ml-2">{{ $ticket->registration->notes }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Daftar pada:</span>
                                <span class="ml-2">{{ $ticket->registration->registration_time->format('d F Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Tiket dibuat:</span>
                                <span class="ml-2">{{ $ticket->generated_at->format('d F Y, H:i') }}</span>
                            </div>
                            @if($ticket->scanned_at)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.293a1 1 0 00-1.414 0L10 10.586 8.707 9.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 12.414l1.293 1.293a1 1 0 001.414 0l4-4a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-medium">Dipindai pada:</span>
                                    <span class="ml-2">{{ $ticket->scanned_at->format('d F Y, H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center">
        <a href="{{ route('donor.tickets.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Tiket
        </a>
        
        <div class="space-x-4">
            @if($ticket->status == 'generated' && !$ticket->expires_at->isPast())
                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Tiket
                </button>
            @endif
            
            <a href="{{ route('donor.queue.show', $ticket->registration->schedule) }}" 
               class="inline-flex items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100">
                <i class="fas fa-users mr-2"></i>
                Lihat Antrian
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gradient-to-r {
        background: linear-gradient(to right, rgb(239 68 68), rgb(220 38 38)) !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection
