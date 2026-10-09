@extends('layouts.app')

@section('title', 'E-Ticket')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">E-Ticket</h1>
            <p class="mt-2 text-gray-600">Tiket digital Anda untuk donor darah</p>
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

        @if($registration->eTicket)
            <!-- E-Ticket Card -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Ticket Header -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $registration->schedule->title }}</h2>
                            <p class="text-red-100 mt-1">{{ $registration->schedule->location }}</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-white text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $registration->eTicket->ticket_code }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Event Details -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Acara</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                                        <p class="font-medium text-gray-900">{{ $registration->schedule->start_time->format('l, F j, Y') }}</p>
                                        <p class="font-medium text-gray-900">{{ $registration->schedule->start_time->format('H:i') }} - {{ $registration->schedule->end_time->format('H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Lokasi</p>
                                        <p class="font-medium text-gray-900">{{ $registration->schedule->location }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Penyelenggara</p>
                                        <p class="font-medium text-gray-900">Peduli Darah</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - QR Code & Status -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code</h3>
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                @if($registration->eTicket->qr_code)
                                    <img src="data:image/png;base64,{{ $registration->eTicket->qr_code }}" alt="QR Code" class="w-48 h-48 mx-auto mb-3">
                                @else
                                    <div class="w-48 h-48 bg-gray-200 mx-auto mb-3 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <p class="text-sm text-gray-600">Scan kode ini di lokasi</p>
                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Status Tiket</p>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    @if($registration->eTicket->status == 'used') bg-green-100 text-green-800
                                    @elseif($registration->eTicket->status == 'scanned') bg-blue-100 text-blue-800
                                    @elseif($registration->eTicket->status == 'expired') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($registration->eTicket->status) }}
                                </span>
                            </div>

                            @if($registration->eTicket->expires_at)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">Kadaluarsa pada</p>
                                    <p class="font-medium text-gray-900">{{ $registration->eTicket->expires_at->format('M j, Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Donor Information -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendonor</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="font-medium text-gray-900">{{ auth()->user()->nama_lengkap }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Golongan Darah</p>
                                <p class="font-medium text-gray-900">{{ auth()->user()->donorProfile->golongan_darah ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Telepon</p>
                                <p class="font-medium text-gray-900">{{ auth()->user()->no_telp }}</p>
                            </div>
                        </div>

                        @if($registration->queue)
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Nomor Antrean</p>
                                <p class="font-medium text-gray-900">#{{ $registration->queue->queue_number }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div class="flex space-x-3">
                            <a href="{{ route('donor.queue.show', $registration->schedule) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                Lihat Antrean
                            </a>
                            
                            <button onclick="window.print()" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
                                </svg>
                                Cetak Tiket
                            </button>

                            <a href="{{ route('donor.eticket.print-formulir', $registration) }}"
                               class="inline-flex items-center px-4 py-2 border border-red-400 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                Cetak Formulir Kuesioner
                            </a>
                        </div>

                        <div class="text-sm text-gray-500">
                            <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Dibuat pada {{ $registration->eTicket->generated_at->format('M j, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-blue-900 font-semibold mb-2">Catatan Penting:</h4>
                <ul class="text-blue-800 text-sm space-y-1">
                    <li>• Harap tiba 15 menit sebelum waktu yang dijadwalkan</li>
                    <li>• Bawa kartu identitas yang valid untuk verifikasi</li>
                    <li>• Tiket ini tidak dapat dipindahtangankan</li>
                    <li>• Pastikan Anda dalam kondisi kesehatan yang baik</li>
                    <li>• Makan makanan ringan sebelum mendonor</li>
                </ul>
            </div>
        @else
            <!-- No E-Ticket -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada E-Ticket</h3>
                <p class="mt-1 text-sm text-gray-500">E-ticket Anda akan dibuat setelah konfirmasi pendaftaran.</p>
            </div>
        @endif
    </div>
</div>
@endsection
