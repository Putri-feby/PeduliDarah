@extends('layouts.app')

@section('title', 'Detail Kolaborasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Kolaborasi</h1>
                <p class="text-red-100">Informasi lengkap permintaan kolaborasi dari {{ $collaboration->organization_name ?: $collaboration->name }}</p>
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
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->event_name }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Event</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $collaboration->event_type == 'Private' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                        {{ $collaboration->event_type ?? 'Publik' }}
                    </span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan PMI</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">{{ $collaboration->pmi_id ?: '-' }}</div>
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

    <!-- Status Information -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Catatan</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Saat Ini</label>
                <div class="inline-flex items-center">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $collaboration->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($collaboration->status == 'under_review' ? 'bg-purple-100 text-purple-800' : 
                           ($collaboration->status == 'approved' ? 'bg-green-100 text-green-800' : 
                           'bg-red-100 text-red-800')) }}">
                        {{ $collaboration->status == 'pending' ? 'Menunggu' : 
                           ($collaboration->status == 'under_review' ? 'Sedang Direview' : 
                           ($collaboration->status == 'approved' ? 'Disetujui' : 'Ditolak')) }}
                    </span>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Update Terakhir</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->updated_at->format('d F Y - H:i') }}
                </div>
            </div>
        </div>

        @if($collaboration->admin_notes)
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl">
                    <p class="text-blue-800 whitespace-pre-wrap">{{ $collaboration->admin_notes }}</p>
                </div>
            </div>
        @endif

        @if($collaboration->admin_id)
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Diupdate Oleh</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-sm">
                            {{ strtoupper(substr($collaboration->admin->nama_lengkap, 0, 1)) }}
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900">
                            {{ $collaboration->admin->nama_lengkap }}
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.collaborations.index') }}" 
               class="px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
            
            <a href="mailto:{{ $collaboration->contact_email }}" 
               class="px-6 py-3 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                Kirim Email
            </a>
            
            <a href="{{ route('admin.collaborations.edit', $collaboration) }}" 
               class="px-6 py-3 border border-yellow-300 shadow-sm text-sm font-medium rounded-md text-yellow-700 bg-yellow-50 hover:bg-yellow-100 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Edit Status
            </a>
            
            <a href="{{ route('admin.collaborations.print', $collaboration) }}" 
               target="_blank"
               class="px-6 py-3 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                <i class="fas fa-file-pdf mr-2"></i>
                Cetak Surat Kolaborasi
            </a>
            
            @if($collaboration->status == 'approved' && !$collaboration->donationSchedule)
            <a href="{{ route('admin.schedules.create', ['collaboration_id' => $collaboration->id]) }}" 
               class="px-6 py-3 border border-green-300 shadow-sm text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
                <i class="fas fa-calendar-plus mr-2"></i>
                Buat Jadwal
            </a>
            @elseif($collaboration->donationSchedule)
            <a href="{{ route('admin.schedules.show', $collaboration->donationSchedule->id ?? 0) }}" 
               class="px-6 py-3 border border-purple-300 shadow-sm text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100 transition-colors">
                <i class="fas fa-calendar-check mr-2"></i>
                Lihat Jadwal
            </a>
            @endif
            
            <form action="{{ route('admin.collaborations.destroy', $collaboration) }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus kolaborasi ini? Tindakan ini tidak dapat dibatalkan.')" 
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
