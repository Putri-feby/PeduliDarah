@extends('layouts.app')

@section('title', 'Konfirmasi Pendaftaran Donor')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Pendaftaran</h1>
        <p class="text-gray-600">Periksa kembali data Anda sebelum mengonfirmasi pendaftaran</p>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Jadwal</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="block font-semibold">Acara:</span>
                    {{ $schedule->title }}
                </div>
                <div>
                    <span class="block font-semibold">Lokasi:</span>
                    {{ $schedule->location }}
                </div>
                <div>
                    <span class="block font-semibold">Tanggal:</span>
                    {{ $schedule->start_time->format('d M Y') }}
                </div>
                <div>
                    <span class="block font-semibold">Waktu:</span>
                    {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900">Data Registrasi Pendonor</h2>
                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Otomatis dari profil</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="block font-semibold">Nama Lengkap:</span>
                    {{ $user->nama_lengkap }}
                </div>
                <div>
                    <span class="block font-semibold">NIK:</span>
                    {{ $user->nik }}
                </div>
                <div>
                    <span class="block font-semibold">Email:</span>
                    {{ $user->email }}
                </div>
                <div>
                    <span class="block font-semibold">No. Telepon:</span>
                    {{ $user->no_telp }}
                </div>
                <div>
                    <span class="block font-semibold">Jenis Kelamin:</span>
                    {{ ucfirst($user->jenis_kelamin) }}
                </div>
                <div>
                    <span class="block font-semibold">Golongan Darah:</span>
                    {{ $donorProfile->golongan_darah ?? '-' }}{{ $donorProfile->rhesus ?? '' }}
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('donor.register.schedule', $schedule) }}" method="POST" class="bg-white overflow-hidden shadow rounded-lg">
        @csrf
        <div class="p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                <textarea name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Kebutuhan khusus atau catatan..."></textarea>
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('donor.schedules.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 text-sm font-medium">Batal</a>
                <button type="submit" 
                        class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Konfirmasi Pendaftaran
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
