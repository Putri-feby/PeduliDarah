@extends('layouts.app')

@section('title', 'Detail Kolaborasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Kolaborasi</h1>
                <p class="text-red-100">Informasi lengkap pengajuan kolaborasi Anda</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-handshake text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Organization Information -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Pengaju</h3>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Organisasi/Perorangan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->name }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama PIC</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->pic_name }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <a href="mailto:{{ $collaboration->email }}" class="text-blue-600 hover:text-blue-800">{{ $collaboration->email }}</a>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <a href="tel:{{ $collaboration->phone }}" class="text-blue-600 hover:text-blue-800">{{ $collaboration->phone }}</a>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Organisasi</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->organization_type }}</div>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->address }}</div>
            </div>
        </div>
    </div>

    <!-- Event Information -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Kegiatan</h3>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->event_name }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pelaksanaan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->proposed_date ? $collaboration->proposed_date->format('d F Y') : '-' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Pelaksanaan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->proposed_time }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Kegiatan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->location }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    @if($collaboration->maps_link)
                        <a href="{{ $collaboration->maps_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">Buka di Maps</a>
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Peserta</h3>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Jumlah Calon Pendonor</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl font-semibold">{{ $collaboration->estimated_donors }} orang</div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Fasilitas Disediakan</h3>
                <ul class="space-y-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <li class="flex items-center">
                        <i class="fas {{ $collaboration->has_room ? 'fa-check text-green-500' : 'fa-times text-red-500' }} w-6 text-center mr-2"></i>
                        <span>Ketersediaan Ruangan</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas {{ $collaboration->has_furniture ? 'fa-check text-green-500' : 'fa-times text-red-500' }} w-6 text-center mr-2"></i>
                        <span>Meja dan Kursi</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas {{ $collaboration->has_electricity ? 'fa-check text-green-500' : 'fa-times text-red-500' }} w-6 text-center mr-2"></i>
                        <span>Listrik</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas {{ $collaboration->has_parking ? 'fa-check text-green-500' : 'fa-times text-red-500' }} w-6 text-center mr-2"></i>
                        <span>Area Parkir</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline Status</h3>
        
        <div class="space-y-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Pengajuan Dikirim</p>
                    <p class="text-sm text-gray-500">{{ $collaboration->created_at->format('d F Y - H:i') }}</p>
                </div>
            </div>
            
            @if($collaboration->status != 'pending')
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Sedang Direview</p>
                        <p class="text-sm text-gray-500">Permintaan sedang ditinjau oleh tim kami</p>
                    </div>
                </div>
            @endif
            
            @if($collaboration->status == 'approved')
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Disetujui</p>
                        <p class="text-sm text-gray-500">Kolaborasi telah disetujui</p>
                    </div>
                </div>
            @elseif($collaboration->status == 'rejected')
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Ditolak</p>
                        <p class="text-sm text-gray-500">Kolaborasi tidak dapat disetujui</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center">
        <a href="{{ route('donor.collaborations') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
        
        @if($collaboration->status == 'pending')
            <button class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i class="fas fa-edit mr-2"></i>
                Edit Pengajuan
            </button>
        @endif
    </div>
</div>

<style>
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
</style>
@endsection
