@extends('layouts.app')

@section('title', 'Riwayat Scan Tiket')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Riwayat Scan Tiket</h1>
                    <p class="mt-2 text-gray-600">Daftar semua tiket yang telah diverifikasi</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.tickets.scan') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-red-700">
                        <i class="fas fa-qrcode mr-2"></i>
                        Scan Tiket
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Options -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.tickets.history') }}" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           class="px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500"
                           placeholder="Kode tiket atau nama pendonor">
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" 
                           id="date_from" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
                </div>
                
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" 
                           id="date_to" 
                           name="date_to" 
                           value="{{ request('date_to') }}"
                           class="px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
                </div>
                
                <div>
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-gray-700">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                </div>
                
                @if(request()->hasAny(['search', 'date_from', 'date_to']))
                    <div>
                        <a href="{{ route('admin.tickets.history') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-times mr-2"></i>
                            Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Results Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($scannedTickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Tiket
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pendonor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acara
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Antrian
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Scan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($scannedTickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $ticket->ticket_code }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">
                                                {{ $ticket->registration->user->nama_lengkap }}
                                            </div>
                                            <div class="text-gray-500">
                                                {{ $ticket->registration->user->email }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $ticket->registration->schedule->title }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $ticket->registration->schedule->start_time->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $ticket->registration->schedule->location }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            #{{ $ticket->registration->queue->queue_number ?? 'Belum ada' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $ticket->status == 'scanned' ? 'bg-blue-100 text-blue-800' : 
                                               ($ticket->status == 'used' ? 'bg-gray-100 text-gray-800' : 
                                               'bg-green-100 text-green-800') }}">
                                            {{ $ticket->status == 'scanned' ? 'Dipindai' : 
                                               ($ticket->status == 'used' ? 'Digunakan' : 'Aktif') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $ticket->scanned_at ? $ticket->scanned_at->format('d M Y H:i') : '-' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="{{ $scannedTickets->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="{{ $scannedTickets->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Menampilkan
                                    <span class="font-medium">{{ $scannedTickets->firstItem() }}</span>
                                    hingga
                                    <span class="font-medium">{{ $scannedTickets->lastItem() }}</span>
                                    dari
                                    <span class="font-medium">{{ $scannedTickets->total() }}</span>
                                    hasil
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    @if($scannedTickets->onFirstPage())
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $scannedTickets->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            Previous
                                        </a>
                                    @endif

                                    <!-- Pagination links -->
                                    @foreach($scannedTickets->links() as $link)
                                        @if($link['active'])
                                            <span class="relative inline-flex items-center px-4 py-2 border border-red-500 bg-red-50 text-sm font-medium text-red-600">
                                                {{ $link['label'] }}
                                            </span>
                                        @else
                                            <a href="{{ $link['url'] }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                {{ $link['label'] }}
                                            </a>
                                        @endif
                                    @endforeach

                                    @if($scannedTickets->hasMorePages())
                                        <a href="{{ $scannedTickets->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            Next
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">
                                            Next
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-ticket-alt text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Scan</h3>
                    <p class="text-gray-500 mb-6">
                        Belum ada tiket yang dipindai. Mulai scan tiket pendonor sekarang.
                    </p>
                    <a href="{{ route('admin.tickets.scan') }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-red-700">
                        <i class="fas fa-qrcode mr-2"></i>
                        Mulai Scan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
