@extends('layouts.app')

@section('title', 'Buat Jadwal')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Buat Jadwal Donor Darah</h1>
                <p class="text-red-100">Buat jadwal donor darah baru</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-calendar-plus text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-6 py-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Jadwal</h3>
            <p class="mt-1 text-sm text-gray-500">Isi detail untuk jadwal donor darah baru</p>
        </div>
        
        <div class="border-t border-gray-200">
            <form action="{{ route('admin.schedules.store') }}" method="POST" class="p-6">
                @csrf
                
                @if(isset($collaboration))
                    <input type="hidden" name="collaboration_id" value="{{ $collaboration->id }}">
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Type -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Event <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="event_type" value="Publik" class="h-4 w-4 text-red-600 focus:ring-red-500" 
                                    {{ old('event_type', isset($collaboration) ? $collaboration->event_type : 'Publik') == 'Publik' ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Publik (Terbuka untuk umum)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="event_type" value="Private" class="h-4 w-4 text-red-600 focus:ring-red-500" 
                                    {{ old('event_type', isset($collaboration) ? $collaboration->event_type : '') == 'Private' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Private (Khusus undangan)</span>
                            </label>
                        </div>
                        @error('event_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               required
                               value="{{ old('title', isset($collaboration) ? $collaboration->event_name : '') }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
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
                                  required
                                  rows="4"
                                  class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
                                  placeholder="Deskripsikan acara donor darah ini...">{{ old('description', isset($collaboration) ? 'Kolaborasi dengan: ' . $collaboration->name . "\nPIC: " . $collaboration->pic_name : '') }}</textarea>
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
                               required
                               value="{{ old('location', isset($collaboration) ? $collaboration->location : '') }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
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
                               required
                               value="{{ old('start_time') }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300">
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
                               required
                               value="{{ old('end_time') }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300">
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
                               required
                               min="1"
                               value="{{ old('max_donors', isset($collaboration) ? (int)$collaboration->estimated_donors : 50) }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
                               placeholder="50">
                        @error('max_donors')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Awal
                        </label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Terjadwal
                            </span>
                            <p class="text-sm text-gray-500 mt-1">Status akan otomatis berubah saat waktu mulai tiba</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.schedules.index') }}" 
                       class="px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set minimum datetime to now
document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);
    
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    startTimeInput.min = localDateTime;
    endTimeInput.min = localDateTime;
    
    // Ensure end time is after start time
    startTimeInput.addEventListener('change', function() {
        endTimeInput.min = this.value;
        if (endTimeInput.value && endTimeInput.value <= this.value) {
            const endTime = new Date(this.value);
            endTime.setHours(endTime.getHours() + 2);
            endTimeInput.value = endTime.toISOString().slice(0, 16);
        }
    });
});
</script>
@endsection
