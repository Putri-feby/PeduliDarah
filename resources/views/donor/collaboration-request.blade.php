@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mb-4 shadow-md">
                <i class="fas fa-handshake text-3xl"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">Ajukan Kolaborasi</h1>
            <p class="text-gray-600 text-base max-w-xl mx-auto">Bergabunglah bersama kami dalam aksi kemanusiaan menyelamatkan nyawa melalui kolaborasi penyelenggaraan donor darah.</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-500 rounded-r-xl p-4 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <!-- Top Accent Bar -->
            <div class="h-2 bg-gradient-to-r from-red-600 to-red-500"></div>
            
            <form action="{{ route('donor.collaboration-request.store') }}" method="POST" class="p-8 sm:p-10 space-y-8">
                @csrf
                
                <!-- Informasi Pengaju -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-red-50 text-[#cc0000] flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-building"></i>
                        </span>
                        Informasi Pengaju / Organisasi
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Organisasi / Perorangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Contoh: Universitas Terbuka" required>
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="pic_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Penanggung Jawab (PIC) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="pic_name" name="pic_name" value="{{ old('pic_name') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Masukkan nama PIC" required>
                            @error('pic_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Resmi <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="email@organisasi.org" required>
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Telepon / WA <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Contoh: 081234567890" required>
                            @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="organization_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Organisasi <span class="text-red-500">*</span>
                            </label>
                            <select id="organization_type" name="organization_type" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors bg-white" required>
                                <option value="">Pilih jenis organisasi</option>
                                <option value="Perusahaan" {{ old('organization_type') == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                <option value="Instansi Pemerintah" {{ old('organization_type') == 'Instansi Pemerintah' ? 'selected' : '' }}>Instansi Pemerintah</option>
                                <option value="Sekolah/Universitas" {{ old('organization_type') == 'Sekolah/Universitas' ? 'selected' : '' }}>Sekolah/Universitas</option>
                                <option value="Komunitas" {{ old('organization_type') == 'Komunitas' ? 'selected' : '' }}>Komunitas</option>
                                <option value="Tempat Ibadah" {{ old('organization_type') == 'Tempat Ibadah' ? 'selected' : '' }}>Tempat Ibadah</option>
                                <option value="Organisasi Lainnya" {{ old('organization_type') == 'Organisasi Lainnya' ? 'selected' : '' }}>Organisasi Lainnya</option>
                            </select>
                            @error('organization_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap Organisasi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Masukkan alamat lengkap kantor atau lokasi organisasi" required>{{ old('address') }}</textarea>
                            @error('address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="pmi_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Unit PMI Tujuan Kolaborasi <span class="text-red-500">*</span>
                            </label>
                            <select id="pmi_id" name="pmi_id" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors bg-white" required>
                                <option value="">Pilih Tujuan PMI</option>
                                @foreach($pmis as $pmi)
                                    <option value="{{ $pmi }}" {{ old('pmi_id') == $pmi ? 'selected' : '' }}>{{ $pmi }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-gray-400">Pilih unit PMI terdekat yang akan melayani kegiatan donor darah kolaborasi Anda.</p>
                            @error('pmi_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Informasi Kegiatan -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-red-50 text-[#cc0000] flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        Detail Kegiatan
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Jenis Akses Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <label class="flex-1 flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="radio" name="event_type" value="Publik" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('event_type', 'Publik') == 'Publik' ? 'checked' : '' }} required>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">Publik</span>
                                        <span class="block text-xs text-gray-500">Terbuka untuk masyarakat umum</span>
                                    </div>
                                </label>
                                <label class="flex-1 flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="radio" name="event_type" value="Private" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('event_type') == 'Private' ? 'checked' : '' }}>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">Privat</span>
                                        <span class="block text-xs text-gray-500">Khusus untuk anggota internal/undangan</span>
                                    </div>
                                </label>
                            </div>
                            @error('event_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="event_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Kegiatan Donor Darah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="event_name" name="event_name" value="{{ old('event_name') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Contoh: Bakti Sosial Donor Darah HUT Mandiri" required>
                            @error('event_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="proposed_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                Rencana Tanggal Pelaksanaan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="proposed_date" name="proposed_date" value="{{ old('proposed_date') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" required>
                            @error('proposed_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="proposed_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                Waktu Mulai Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="time" id="proposed_time" name="proposed_time" value="{{ old('proposed_time') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" required>
                            @error('proposed_time')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                                Lokasi Pelaksanaan Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Masukkan nama tempat / aula / gedung" required>
                            @error('location')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="maps_link" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tautan Google Maps Lokasi (opsional)
                            </label>
                            <input type="url" id="maps_link" name="maps_link" value="{{ old('maps_link') }}" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="https://maps.app.goo.gl/...">
                            @error('maps_link')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Informasi Peserta -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-red-50 text-[#cc0000] flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-users font-semibold"></i>
                        </span>
                        Informasi Peserta
                    </h2>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Estimasi Jumlah Calon Pendonor <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center justify-center p-4 bg-gray-50 rounded-2xl border border-gray-200 cursor-pointer hover:bg-red-50 hover:border-red-300 transition-all text-center">
                                <input type="radio" name="estimated_donors" value="< 50" class="h-4 w-4 text-red-600 focus:ring-red-500 mr-2" {{ old('estimated_donors') == '< 50' ? 'checked' : '' }} required>
                                <span class="text-gray-900 font-bold">&lt; 50</span>
                            </label>
                            <label class="flex items-center justify-center p-4 bg-gray-50 rounded-2xl border border-gray-200 cursor-pointer hover:bg-red-50 hover:border-red-300 transition-all text-center">
                                <input type="radio" name="estimated_donors" value="50-500" class="h-4 w-4 text-red-600 focus:ring-red-500 mr-2" {{ old('estimated_donors') == '50-500' ? 'checked' : '' }}>
                                <span class="text-gray-900 font-bold">50 - 500</span>
                            </label>
                            <label class="flex items-center justify-center p-4 bg-gray-50 rounded-2xl border border-gray-200 cursor-pointer hover:bg-red-50 hover:border-red-300 transition-all text-center">
                                <input type="radio" name="estimated_donors" value="500-1000" class="h-4 w-4 text-red-600 focus:ring-red-500 mr-2" {{ old('estimated_donors') == '500-1000' ? 'checked' : '' }}>
                                <span class="text-gray-900 font-bold">500 - 1000</span>
                            </label>
                            <label class="flex items-center justify-center p-4 bg-gray-50 rounded-2xl border border-gray-200 cursor-pointer hover:bg-red-50 hover:border-red-300 transition-all text-center">
                                <input type="radio" name="estimated_donors" value="> 1000" class="h-4 w-4 text-red-600 focus:ring-red-500 mr-2" {{ old('estimated_donors') == '> 1000' ? 'checked' : '' }}>
                                <span class="text-gray-900 font-bold">&gt; 1000</span>
                            </label>
                        </div>
                        @error('estimated_donors')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Fasilitas -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-red-50 text-[#cc0000] flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-tools"></i>
                        </span>
                        Fasilitas Penunjang Lokasi
                    </h2>
                    <p class="text-sm text-gray-500 mb-6">Pastikan fasilitas dasar di lokasi kegiatan berikut ini sudah terpenuhi:</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-200">
                            <span class="text-gray-700 font-semibold">Ketersediaan Ruangan yang Memadai <span class="text-red-500">*</span></span>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_room" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_room') == '1' ? 'checked' : '' }} required>
                                    <span class="ml-2 text-gray-700 font-medium">Ada</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_room" value="0" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_room') == '0' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-200">
                            <span class="text-gray-700 font-semibold">Meja & Kursi untuk Registrasi/Pemeriksaan <span class="text-red-500">*</span></span>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_furniture" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_furniture') == '1' ? 'checked' : '' }} required>
                                    <span class="ml-2 text-gray-700 font-medium">Ada</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_furniture" value="0" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_furniture') == '0' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-200">
                            <span class="text-gray-700 font-semibold">Sumber Aliran Listrik & Stop Kontak <span class="text-red-500">*</span></span>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_electricity" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_electricity') == '1' ? 'checked' : '' }} required>
                                    <span class="ml-2 text-gray-700 font-medium">Ada</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_electricity" value="0" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_electricity') == '0' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-200">
                            <span class="text-gray-700 font-semibold">Area Parkir untuk Ambulans / Mobil Unit PMI <span class="text-red-500">*</span></span>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_parking" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_parking') == '1' ? 'checked' : '' }} required>
                                    <span class="ml-2 text-gray-700 font-medium">Ada</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="has_parking" value="0" class="h-4 w-4 text-red-600 focus:ring-red-500" {{ old('has_parking') == '0' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('donor.dashboard') }}" 
                       class="px-6 py-3 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 font-bold transition-all text-sm">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg text-sm">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-red-50 border border-red-100 rounded-3xl p-6 sm:p-8">
            <h3 class="text-lg font-bold text-red-900 mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2"></i> Ketentuan Pengajuan Kerja Sama
            </h3>
            <div class="space-y-3 text-sm text-red-800 leading-relaxed">
                <p class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Pengajuan kolaborasi ini akan langsung masuk ke database unit PMI yang Anda tuju.</span>
                </p>
                <p class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Tim administrasi PMI akan meninjau kelayakan lokasi dan estimasi jumlah pendonor yang diajukan.</span>
                </p>
                <p class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Proses verifikasi dan koordinasi lanjutan umumnya memakan waktu 2 s.d 3 hari kerja setelah pengajuan dikirimkan.</span>
                </p>
                <p class="flex items-start">
                    <span class="mr-2">•</span>
                    <span>Pastikan nomor PIC/telepon selalu aktif untuk memudahkan koordinasi logistik.</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
