@extends('layouts.app')

@section('title', $readOnly ? 'Detail Jadwal' : 'Edit Jadwal')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $readOnly ? 'Detail Jadwal' : 'Edit Jadwal' }}</h1>
                <p class="text-red-100">{{ $readOnly ? 'Informasi jadwal donor darah: ' : 'Perbarui informasi jadwal donor darah: ' }}{{ $schedule->title }}</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-calendar-alt text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Status -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Saat Ini</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $schedule->status == 'upcoming' ? 'bg-yellow-100 text-yellow-800' : 
                           ($schedule->status == 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                           ($schedule->status == 'completed' ? 'bg-green-100 text-green-800' : 
                           'bg-red-100 text-red-800')) }}">
                        {{ $schedule->status == 'upcoming' ? 'Terjadwal' : 
                           ($schedule->status == 'ongoing' ? 'Berlangsung' : 
                           ($schedule->status == 'completed' ? 'Selesai' : 'Dibatalkan')) }}
                    </span>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total Pendaftar</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $schedule->current_donors }} / {{ $schedule->max_donors }}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Tersisa</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $schedule->max_donors - $schedule->current_donors }} slot
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat Oleh</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    {{ $schedule->pmi_id ?: ($schedule->admin ? $schedule->admin->pmi_id : 'System') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Banner Read-Only --}}
    @if($readOnly)
    <div class="mb-6 p-4 bg-gray-50 border border-gray-300 rounded-xl flex items-start gap-3">
        <div class="flex-shrink-0 w-9 h-9 bg-gray-200 rounded-lg flex items-center justify-center">
            <i class="fas fa-lock text-gray-500"></i>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-gray-700">Jadwal Sudah Selesai</h4>
            <p class="text-sm text-gray-500 mt-0.5">Jadwal ini berstatus <span class="font-semibold text-green-700">Selesai</span> dan tidak dapat diedit. Anda hanya dapat melihat informasinya.</p>
        </div>
    </div>
    @endif

    {{-- Edit Form --}}
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-6 py-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Jadwal</h3>
            <p class="mt-1 text-sm text-gray-500">Perbarui detail jadwal donor darah</p>
        </div>
        
        <div class="border-t border-gray-200">
            <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               {{ $readOnly ? 'disabled' : 'required' }}
                               value="{{ old('title', $schedule->title) }}"
                               class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                               placeholder="Contoh: Donor Darah Rutin Bulanan">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  {{ $readOnly ? 'disabled' : 'required' }}
                                  rows="4"
                                  class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                  placeholder="Deskripsikan acara donor darah ini...">{{ old('description', $schedule->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="md:col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               {{ $readOnly ? 'disabled' : 'required' }}
                               value="{{ old('location', $schedule->location) }}"
                               class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                               placeholder="Contoh: RSUD Kota, Jl. Sehat No. 123">
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="start_time" 
                               name="start_time" 
                               {{ $readOnly ? 'disabled' : 'required' }}
                               value="{{ old('start_time', $schedule->start_time->format('Y-m-d\TH:i')) }}"
                               class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                        @error('start_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="end_time" 
                               name="end_time" 
                               {{ $readOnly ? 'disabled' : 'required' }}
                               value="{{ old('end_time', $schedule->end_time->format('Y-m-d\TH:i')) }}"
                               class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                        @error('end_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Donors -->
                    <div>
                        <label for="max_donors" class="block text-sm font-medium text-gray-700 mb-2">
                            Kapasitas Maksimal <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="max_donors" 
                               name="max_donors" 
                               {{ $readOnly ? 'disabled' : 'required' }}
                               min="{{ $schedule->current_donors }}"
                               value="{{ old('max_donors', $schedule->max_donors) }}"
                               class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                               placeholder="50">
                        @error('max_donors')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Minimal: {{ $schedule->current_donors }} (sudah terdaftar)</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                {{ $readOnly ? 'disabled' : 'required' }}
                                class="block w-full px-4 py-3 border-2 {{ $readOnly ? 'border-gray-100 bg-gray-50 text-gray-500 cursor-not-allowed' : 'border-gray-200 hover:border-red-300' }} rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                            <option value="upcoming" {{ $schedule->status == 'upcoming' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="ongoing" {{ $schedule->status == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $schedule->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Warning for Capacity Change -->
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <h4 class="text-sm font-semibold text-yellow-900 mb-2">Perhatian</h4>
                    <ul class="text-sm text-yellow-800 space-y-1">
                        <li> Mengubah kapasitas tidak akan menghapus pendaftaran yang sudah ada</li>
                        <li> Mengubah waktu dapat mempengaruhi jadwal donor yang sudah terdaftar</li>
                        <li> Mengubah status ke "Dibatalkan" akan menghentikan semua aktivitas</li>
                    </ul>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.schedules.index') }}" 
                       class="px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>{{ $readOnly ? 'Kembali' : 'Batal' }}
                    </a>
                    @if(!$readOnly)
                    <button type="submit" 
                            class="px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Jadwal
                    </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set minimum datetime validation
document.addEventListener('DOMContentLoaded', function() {
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    // Ensure end time is after start time
    startTimeInput.addEventListener('change', function() {
        endTimeInput.min = this.value;
        if (endTimeInput.value && endTimeInput.value <= this.value) {
            const endTime = new Date(this.value);
            endTime.setHours(endTime.getHours() + 2);
            endTimeInput.value = endTime.toISOString().slice(0, 16);
        }
    });
    
    // Initial validation
    if (startTimeInput.value) {
        endTimeInput.min = startTimeInput.value;
    }
});
</script>
@endsection
