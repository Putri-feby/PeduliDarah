@extends('layouts.app')

@section('title', 'Manajemen Antrian')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Antrian</h1>
                <p class="text-red-100">Kelola antrian donor darah: {{ $schedule->title }}</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Info -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $schedule->title }}</h3>
                <p class="text-gray-600">{{ $schedule->location }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->start_time->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $schedule->status == 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                       ($schedule->status == 'completed' ? 'bg-green-100 text-green-800' : 
                       'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($schedule->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Antrian Saat Ini -->
    @if($currentQueue)
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                        {{ $currentQueue->queue_number }}
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-blue-900">Sedang Dilayani</h4>
                        <p class="text-blue-700">{{ $currentQueue->registration->user->nama_lengkap }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('admin.queue.complete', $currentQueue) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>Selesai
                        </button>
                    </form>
                    <form action="{{ route('admin.queue.skip', $currentQueue) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors" onclick="return confirm('Apakah Anda yakin ingin melewati pendonor ini?')">
                            <i class="fas fa-forward mr-2"></i>Skip
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Daftar Antrian -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-6 py-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Antrian</h3>
            <p class="mt-1 text-sm text-gray-500">Kelola antrian donor yang menunggu</p>
        </div>
        
        <div class="border-t border-gray-200">
            @if($queues->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Antrian
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Tiket
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
                            @foreach($queues as $queue)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-red-600">
                                                {{ $queue->queue_number }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $queue->registration->user->nama_lengkap }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ $queue->registration->user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($queue->registration->eTicket)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ in_array($queue->registration->eTicket->status, ['scanned', 'used']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ in_array($queue->registration->eTicket->status, ['scanned', 'used']) ? 'Terverifikasi' : 'Belum Diverifikasi' }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                -
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClass = match($queue->status) {
                                                'waiting' => 'bg-gray-100 text-gray-800',
                                                'preparing' => 'bg-yellow-100 text-yellow-800',
                                                'called' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'skipped' => 'bg-orange-100 text-orange-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                            $statusText = match($queue->status) {
                                                'waiting' => 'Menunggu',
                                                'preparing' => 'Bersiap',
                                                'called' => 'Dipanggil',
                                                'completed' => 'Selesai',
                                                'skipped' => 'Skipped',
                                                'failed' => 'Gagal Donor',
                                                default => $queue->status,
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if(in_array($queue->status, ['waiting', 'preparing', 'skipped']))
                                            <form action="{{ route('admin.queue.call', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <i class="fas fa-bullhorn"></i> {{ $queue->status === 'skipped' ? 'Panggil Lagi' : 'Panggil' }}
                                                </button>
                                            </form>
                                        @endif
                                        @if($queue->status == 'called' && $currentQueue && $currentQueue->id == $queue->id)
                                            <form action="{{ route('admin.queue.complete', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                                    <i class="fas fa-check"></i> Selesai
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.queue.skip', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Apakah Anda yakin ingin melewati pendonor ini?')">
                                                    <i class="fas fa-forward"></i> Skip
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-users text-gray-400 text-5xl mb-4"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada antrian</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada donor yang mengantri untuk jadwal ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Jadwal
        </a>
    </div>
</div>
@endsection
