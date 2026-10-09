@extends('layouts.app')

@section('title', 'Tiket Saya')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tiket Saya</h1>
        <p class="text-gray-600">Kelola dan lihat semua tiket donor darah Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-4 sm:p-6 card-hover">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-red-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Tiket</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $tickets->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-4 sm:p-6 card-hover">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Aktif</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $tickets->where('status', 'generated')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-4 sm:p-6 card-hover">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-qrcode text-blue-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Sudah Dipindai</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $tickets->where('status', 'scanned')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-4 sm:p-6 card-hover">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-gray-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Kadaluarsa</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $tickets->where('status', 'expired')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 sm:py-5">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Daftar Tiket</h3>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">Semua tiket donor darah Anda</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200">
            @if($tickets->count() > 0)
                <!-- Mobile Card View -->
                <div class="sm:hidden">
                    @foreach($tickets as $ticket)
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $ticket->ticket_code }}</div>
                                    <div class="text-xs text-gray-500">{{ $ticket->generated_at->format('d M Y, H:i') }}</div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $ticket->status == 'generated' ? 'bg-green-100 text-green-800' :
                                       ($ticket->status == 'scanned' ? 'bg-blue-100 text-blue-800' :
                                       ($ticket->status == 'used' ? 'bg-gray-100 text-gray-800' :
                                       'bg-red-100 text-red-800')) }}">
                                    {{ $ticket->status == 'generated' ? 'Aktif' :
                                       ($ticket->status == 'scanned' ? 'Dipindai' :
                                       ($ticket->status == 'used' ? 'Digunakan' : 'Kadaluarsa')) }}
                                </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Acara:</span>
                                    <span class="ml-2 text-gray-900">{{ $ticket->registration->schedule->title }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Tanggal:</span>
                                    <span class="ml-2 text-gray-900">{{ $ticket->registration->schedule->start_time->format('d M Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Waktu:</span>
                                    <span class="ml-2 text-gray-900">{{ $ticket->registration->schedule->start_time->format('H:i') }} - {{ $ticket->registration->schedule->end_time->format('H:i') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Lokasi:</span>
                                    <span class="ml-2 text-gray-900">{{ $ticket->registration->schedule->location }}</span>
                                </div>
                            </div>
                            @if($ticket->expires_at && $ticket->expires_at->isPast())
                                <div class="mt-2 text-xs text-red-600">Kadaluarsa</div>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('donor.tickets.show', $ticket) }}"
                                   class="inline-flex items-center px-3 py-2 border border-red-600 text-sm leading-4 font-medium rounded-md text-red-600 bg-white hover:bg-red-50 w-full justify-center">
                                    <i class="fas fa-eye mr-2"></i> Lihat Tiket
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop Table View -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Tiket
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acara
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $ticket->ticket_code }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $ticket->generated_at->format('d M Y, H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $ticket->registration->schedule->title }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $ticket->registration->schedule->start_time->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $ticket->registration->schedule->start_time->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $ticket->registration->schedule->start_time->format('H:i') }} - {{ $ticket->registration->schedule->end_time->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $ticket->registration->schedule->location }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $ticket->status == 'generated' ? 'bg-green-100 text-green-800' :
                                               ($ticket->status == 'scanned' ? 'bg-blue-100 text-blue-800' :
                                               ($ticket->status == 'used' ? 'bg-gray-100 text-gray-800' :
                                               'bg-red-100 text-red-800')) }}">
                                            {{ $ticket->status == 'generated' ? 'Aktif' :
                                               ($ticket->status == 'scanned' ? 'Dipindai' :
                                               ($ticket->status == 'used' ? 'Digunakan' : 'Kadaluarsa')) }}
                                        </span>
                                        @if($ticket->expires_at && $ticket->expires_at->isPast())
                                            <div class="text-xs text-red-600 mt-1">Kadaluarsa</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('donor.tickets.show', $ticket) }}"
                                           class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-ticket-alt text-gray-400 text-5xl mb-4"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada tiket</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum memiliki tiket donor darah. Daftar untuk jadwal donor untuk mendapatkan tiket.</p>
                    <div class="mt-4">
                        <a href="{{ route('donor.schedules.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Lihat Jadwal Donor
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
