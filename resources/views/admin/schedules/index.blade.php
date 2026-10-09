@extends('layouts.app')

@section('title', 'Manajemen Jadwal')

@section('content')
<div class="w-full overflow-hidden">
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Jadwal</h1>
                <p class="text-red-100">Kelola jadwal donor darah yang tersedia</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-calendar-alt text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 overflow-hidden">
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jadwal</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $schedules->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Akan Datang</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $schedules->where('start_time', '>', now())->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-play-circle text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sedang Berlangsung</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $schedules->where('status', 'ongoing')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $schedules->where('status', 'completed')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Daftar Jadwal</h3>
            <p class="text-sm text-gray-500">Kelola semua jadwal donor darah</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <i class="fas fa-plus mr-2"></i>
            Tambah Jadwal
        </a>
    </div>

    <!-- Schedules List -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="border-t border-gray-200 no-scrollbar overflow-x-auto">
            @if($schedules->count() > 0)
                <table class="w-full divide-y divide-gray-200" style="table-layout: auto;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Judul
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($schedules as $schedule)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $schedule->title }}
                                        </div>
                                        <div class="text-sm text-gray-500 truncate">
                                            {{ strlen($schedule->description) > 50 ? substr($schedule->description, 0, 50) . '...' : $schedule->description }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="text-sm text-gray-900 truncate">
                                            {{ $schedule->location }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $schedule->start_time->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $schedule->event_type == 'Private' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $schedule->event_type ?? 'Publik' }}
                                            </span>
                                            @if($schedule->event_type == 'Private')
                                                <div class="mt-1 font-mono text-xs text-gray-500 bg-gray-100 px-1 rounded inline-block">Kode: {{ $schedule->invitation_code }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $schedule->status == 'upcoming' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($schedule->status == 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                                               ($schedule->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                               'bg-red-100 text-red-800')) }}">
                                            {{ $schedule->status == 'upcoming' ? 'Terjadwal' : 
                                               ($schedule->status == 'ongoing' ? 'Berlangsung' : 
                                               ($schedule->status == 'completed' ? 'Selesai' : 'Dibatalkan')) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.queue.manage', $schedule) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-1" title="Antrian">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            @if($schedule->status === 'completed')
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                                   class="text-gray-400 hover:text-gray-600 p-1" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 p-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-calendar text-gray-400 text-5xl mb-4"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada jadwal donor darah yang dibuat.</p>
                    <div class="mt-4">
                        <a href="{{ route('admin.schedules.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Jadwal Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
