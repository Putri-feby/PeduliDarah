@extends('layouts.app')

@section('title', 'Manajemen Kolaborasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Kolaborasi</h1>
                <p class="text-red-100">Kelola permintaan kolaborasi donor darah</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-handshake text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-handshake text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Kolaborasi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $collaborations->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Review</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $collaborations->where('status', 'pending')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-search text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sedang Direview</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $collaborations->where('status', 'under_review')->count() }}</dd>
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
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $collaborations->where('status', 'approved')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collaborations List -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-6 py-5">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Kolaborasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Kelola permintaan kolaborasi dari organisasi</p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200">
            @if($collaborations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Organisasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kontak
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Diajukan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Donor Diestimasi
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
                            @foreach($collaborations as $collaboration)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $collaboration->organization_name ?: $collaboration->name }}
                                        </div>
                                        @if($collaboration->location)
                                            <div class="text-sm text-gray-500">
                                                {{ $collaboration->location }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $collaboration->contact_person ?: $collaboration->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $collaboration->contact_email ?: $collaboration->email }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $collaboration->contact_phone ?: $collaboration->phone ?: 'Tidak ada telepon' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $collaboration->proposed_date ? $collaboration->proposed_date->format('d M Y') : 'Tidak ditentukan' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $collaboration->expected_donors ?: 'Tidak ditentukan' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $collaboration->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($collaboration->status == 'under_review' ? 'bg-purple-100 text-purple-800' : 
                                               ($collaboration->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                               'bg-red-100 text-red-800')) }}">
                                            {{ $collaboration->status == 'pending' ? 'Menunggu' : 
                                               ($collaboration->status == 'under_review' ? 'Review' : 
                                               ($collaboration->status == 'approved' ? 'Disetujui' : 'Ditolak')) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.collaborations.show', $collaboration) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('admin.collaborations.edit', $collaboration) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.collaborations.destroy', $collaboration) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kolaborasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-handshake text-gray-400 text-5xl mb-4"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kolaborasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada permintaan kolaborasi yang diajukan.</p>
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
