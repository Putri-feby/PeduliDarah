@extends('layouts.app')

@section('title', 'Edit Kolaborasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Kolaborasi</h1>
                <p class="text-red-100">Perbarui status dan catatan kolaborasi: {{ $collaboration->organization_name }}</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-handshake text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Collaboration Details -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Organisasi</h3>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Organisasi</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->organization_name }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->contact_person }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->contact_email }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->contact_phone ?: 'Tidak ada' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->location ?: 'Tidak ditentukan' }}
                </div>
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
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->pmi_id ?: '-' }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Diajukan</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->proposed_date->format('d M Y') }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Donor Diestimasi</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $collaboration->expected_donors ?: 'Tidak ditentukan' }}
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Proposal</h3>
            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                {{ $collaboration->proposal_description }}
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-6 py-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Update Status & Catatan</h3>
            <p class="mt-1 text-sm text-gray-500">Perbarui status kolaborasi dan tambahkan catatan admin</p>
        </div>
        
        <div class="border-t border-gray-200">
            <form action="{{ route('admin.collaborations.update', $collaboration) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                required
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300">
                            <option value="">Pilih Status</option>
                            <option value="pending" {{ $collaboration->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="under_review" {{ $collaboration->status == 'under_review' ? 'selected' : '' }}>Sedang Direview</option>
                            <option value="approved" {{ $collaboration->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ $collaboration->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Admin Notes -->
                    <div class="md:col-span-2">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Admin
                        </label>
                        <textarea id="admin_notes" 
                                  name="admin_notes" 
                                  rows="4"
                                  class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
                                  placeholder="Tambahkan catatan atau feedback untuk organisasi...">{{ old('admin_notes', $collaboration->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Information -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Informasi Status</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">Status Saat Ini:</span>
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $collaboration->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($collaboration->status == 'under_review' ? 'bg-purple-100 text-purple-800' : 
                                   ($collaboration->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                   'bg-red-100 text-red-800')) }}">
                                {{ $collaboration->status == 'pending' ? 'Menunggu' : 
                                   ($collaboration->status == 'under_review' ? 'Review' : 
                                   ($collaboration->status == 'approved' ? 'Disetujui' : 'Ditolak')) }}
                            </span>
                        </div>
                        @if($collaboration->admin_id)
                            <div>
                                <span class="font-medium">Diupdate oleh:</span>
                                <span class="ml-2">{{ $collaboration->admin->nama_lengkap }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="font-medium">Tanggal Update:</span>
                            <span class="ml-2">{{ $collaboration->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.collaborations.index') }}" 
                       class="px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
