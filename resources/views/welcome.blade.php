@extends('layouts.app')

@section('title', 'Peduli Darah - Selamatkan Nyawa')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Mobile Header -->
    <header class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Left: Logo -->
                <div class="flex items-center flex-shrink-0">
                    <img src="{{ asset('images/logo-pmi.svg') }}" alt="Palang Merah Indonesia" class="h-10 sm:h-12 w-auto">
                </div>

                <!-- Center: Navigation Links -->
                <nav class="hidden lg:flex items-center justify-center space-x-6 flex-1 px-8">
                    <a href="#beranda" class="text-red-600 font-semibold border-b-2 border-red-600 pb-1">Beranda</a>
                    <a href="#tentang-kami" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Tentang Kami</a>
                    <a href="#kegiatan" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Kegiatan</a>
                    <a href="#kontak" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Kontak</a>
                </nav>

                <!-- Right: Auth Buttons -->
                <div class="flex items-center justify-end space-x-4 flex-shrink-0">
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center text-gray-700 hover:text-gray-900 font-bold transition-colors text-sm sm:text-base">
                            <i class="fas fa-sign-in-alt mr-2 text-gray-600"></i>
                            <span class="hidden sm:inline">Masuk</span>
                        </a>
                        <a href="{{ route('register') }}" class="bg-[#dc2626] text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-red-700 transition-colors shadow-md text-sm sm:text-base flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span class="hidden sm:inline">Daftar</span>
                            <span class="sm:hidden">Daftar</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-[#dc2626] text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-red-700 transition-colors shadow-md text-sm sm:text-base flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            <span class="hidden sm:inline">Dashboard</span>
                            <span class="sm:hidden">Dashboard</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline ml-2 sm:ml-4">
                            @csrf
                            <button type="submit" class="flex items-center text-gray-700 hover:text-gray-900 font-bold transition-colors text-sm sm:text-base">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-600"></i>
                                <span class="hidden sm:inline">Keluar</span>
                                <span class="sm:hidden"><i class="fas fa-sign-out-alt"></i></span>
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="bg-[#cc0000] text-white mt-20 pt-12 sm:pt-16 relative z-20 overflow-visible">
        <!-- Dot Patterns -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Left Dots -->
            <div class="absolute left-4 sm:left-12 top-1/2 -translate-y-1/2 w-24 h-48 opacity-20" style="background-image: radial-gradient(circle, white 2px, transparent 2px); background-size: 20px 20px;"></div>
            <!-- Right Dots -->
            <div class="absolute right-4 sm:right-12 top-1/2 -translate-y-1/2 w-24 h-48 opacity-20" style="background-image: radial-gradient(circle, white 2px, transparent 2px); background-size: 20px 20px;"></div>
            <!-- Soft Gradient Overlay for depth -->
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-black/5 to-transparent"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <!-- Pill Badge -->
                <div class="mb-6 flex justify-center">
                    <div class="bg-white text-[#cc0000] px-5 py-2 rounded-full font-bold text-sm sm:text-base flex items-center shadow-lg">
                        <i class="fas fa-tint mr-2"></i> Sistem Peduli Darah PMI
                    </div>
                </div>
                
                <!-- Headline -->
                <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold mb-4 leading-tight tracking-tight drop-shadow-md">
                    <span class="text-white">Selamat Datang di</span><br>
                    <span class="text-yellow-400">Peduli Darah</span>
                </h1>
                
                <!-- Description -->
                <p class="text-lg sm:text-2xl mb-8 text-white max-w-3xl mx-auto font-medium px-4">
                    Bergabunglah dalam gerakan kemanusiaan untuk membantu sesama yang membutuhkan.
                </p>
                
                <!-- CTA Button -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center px-4 pb-12 sm:pb-16">
                    @guest
                        <a href="{{ route('register') }}" class="bg-white text-[#cc0000] px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-all hover:shadow-xl text-base sm:text-lg w-full sm:w-auto flex items-center justify-center">
                            <i class="fas fa-heart mr-2"></i>Yuk Donor Sekarang
                        </a>
                        <a href="{{ route('collaborations.create') }}" class="bg-[#a30000] text-white px-8 py-4 rounded-full font-bold hover:bg-[#850000] transition-all shadow-md text-base sm:text-lg w-full sm:w-auto flex items-center justify-center border border-red-700">
                            <i class="fas fa-handshake mr-2"></i>Kerjasama dengan Kami
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-white text-[#cc0000] px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-all hover:shadow-xl text-base sm:text-lg w-full sm:w-auto flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Menuju Dashboard
                        </a>
                        <a href="{{ route('collaborations.create') }}" class="bg-[#a30000] text-white px-8 py-4 rounded-full font-bold hover:bg-[#850000] transition-all shadow-md text-base sm:text-lg w-full sm:w-auto flex items-center justify-center border border-red-700">
                            <i class="fas fa-handshake mr-2"></i>Minta Kerjasama
                        </a>
                    @endguest
                </div>
                
                <!-- Floating Info Bar -->
                <div class="max-w-6xl mx-auto bg-white rounded-[2rem] shadow-xl transform translate-y-1/2 relative z-20 overflow-hidden hidden lg:block border border-gray-100 px-4">
                    <div class="grid grid-cols-3 divide-x divide-gray-100 py-6 sm:py-8">
                        <div class="flex items-center justify-center px-6">
                            <div class="w-14 h-14 rounded-full border-2 border-red-100 flex items-center justify-center mr-5 text-[#cc0000] flex-shrink-0">
                                <i class="fas fa-shield-alt text-xl"></i>
                            </div>
                            <div class="text-left">
                                <h4 class="font-bold text-gray-900 text-base sm:text-lg">Aman & Terpercaya</h4>
                                <p class="text-sm text-gray-500">Data Anda dilindungi</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center px-6">
                            <div class="w-14 h-14 rounded-full border-2 border-red-100 flex items-center justify-center mr-5 text-[#cc0000] flex-shrink-0">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div class="text-left">
                                <h4 class="font-bold text-gray-900 text-base sm:text-lg">Mudah & Cepat</h4>
                                <p class="text-sm text-gray-500">Proses sederhana</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center px-6">
                            <div class="w-14 h-14 rounded-full border-2 border-red-100 flex items-center justify-center mr-5 text-[#cc0000] flex-shrink-0">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div class="text-left">
                                <h4 class="font-bold text-gray-900 text-base sm:text-lg">Bersama Kita Bisa</h4>
                                <p class="text-sm text-gray-500">Selamatkan nyawa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Cards Section -->
    <section id="kegiatan" class="pt-20 sm:pt-24 pb-12 sm:pb-20 bg-gray-50 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div class="flex items-start mb-2">
                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#cc0000] flex-shrink-0 mr-4">
                            <i class="far fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-1">Jadwal Donor</h4>
                            <p class="text-sm text-gray-500 line-clamp-3">Lihat jadwal dan lokasi kegiatan donor darah terdekat.</p>
                        </div>
                    </div>
                    <div class="mt-4 pl-16">
                        <a href="#" class="text-[#cc0000] font-bold text-sm hover:text-red-800 transition-colors inline-flex items-center">
                            Lihat Jadwal <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div class="flex items-start mb-2">
                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#cc0000] flex-shrink-0 mr-4">
                            <i class="fas fa-ticket-alt text-xl transform -rotate-45"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-1">E-Ticket</h4>
                            <p class="text-sm text-gray-500 line-clamp-3">Dapatkan tiket elektronik dan antrean secara online.</p>
                        </div>
                    </div>
                    <div class="mt-4 pl-16">
                        <a href="{{ route('register') }}" class="text-[#cc0000] font-bold text-sm hover:text-red-800 transition-colors inline-flex items-center">
                            Daftar Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div class="flex items-start mb-2">
                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#cc0000] flex-shrink-0 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-1">Cek Antrean</h4>
                            <p class="text-sm text-gray-500 line-clamp-3">Pantau antrean donor darah secara real-time.</p>
                        </div>
                    </div>
                    <div class="mt-4 pl-16">
                        <a href="#" class="text-[#cc0000] font-bold text-sm hover:text-red-800 transition-colors inline-flex items-center">
                            Cek Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div class="flex items-start mb-2">
                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#cc0000] flex-shrink-0 mr-4">
                            <i class="fas fa-handshake text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-1">Kolaborasi</h4>
                            <p class="text-sm text-gray-500 line-clamp-3">Bekerjasama dengan kami untuk kegiatan sosial kemanusiaan.</p>
                        </div>
                    </div>
                    <div class="mt-4 pl-16">
                        <a href="{{ route('register') }}" class="text-[#cc0000] font-bold text-sm hover:text-red-800 transition-colors inline-flex items-center">
                            Hubungi Kami <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang-kami" class="py-16 sm:py-24 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Row 1: Title & Description & Image -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6">
                        Tentang <span class="text-[#cc0000]">Kami</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Peduli Darah adalah sistem informasi yang dikembangkan oleh Palang Merah Indonesia untuk memudahkan masyarakat dalam melakukan donor darah, mendapatkan informasi kegiatan, dan berkolaborasi demi kemanusiaan.
                    </p>
                    <p class="text-[#cc0000] font-bold text-xl italic">
                        Setetes darah Anda, harapan bagi mereka.
                    </p>
                </div>
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-red-400 rounded-3xl blur opacity-10"></div>
                    <img src="{{ asset('images/gedung-pmi.png') }}" alt="Gedung PMI" class="relative rounded-3xl shadow-lg w-full object-cover h-[350px]">
                </div>
            </div>



            <!-- Row 3: Visi & Misi -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-gray-50 rounded-[2.5rem] p-8 sm:p-12 border border-gray-100">
                <!-- Visi -->
                <div class="flex flex-col justify-center text-center lg:text-left">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Visi</h3>
                    <p class="text-gray-600 text-lg leading-relaxed italic">
                        "Terwujudnya pelayanan darah yang aman, bermutu dan berkesinambungan yang diakui di tingkat nasional dan internasional berlandaskan 7 (tujuh) prinsip kepalangmerahan"
                    </p>
                </div>

                <!-- Misi -->
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6 text-center lg:text-left">Misi</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-[#cc0000] mr-3 mt-1">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                            <span class="text-gray-600 text-base">Menjamin ketersedian darah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-[#cc0000] mr-3 mt-1">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                            <span class="text-gray-600 text-base">Memastikan produk darah aman dan bermutu</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-[#cc0000] mr-3 mt-1">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                            <span class="text-gray-600 text-base">Menjamin hak-hak bagi pendonor darah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-[#cc0000] mr-3 mt-1">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                            <span class="text-gray-600 text-base">Memastikan transparansi dalam segala hal yang berkaitan dengan pelayanan darah dan upaya pengolahan darah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-[#cc0000] mr-3 mt-1">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                            <span class="text-gray-600 text-base">Memberikan kemudahan akses permintan darah bagi Pasien dan Rumah Sakit</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="dampak-positif" class="py-12 sm:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-16">
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">Dampak Positif</h3>
                <p class="text-base sm:text-xl text-gray-600 max-w-2xl mx-auto px-4">Bersama kita telah membuat perbedaan nyata dalam menyelamatkan nyawa</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-8 px-4">
                <div class="red-gradient-light rounded-2xl p-4 sm:p-8 text-center card-hover border border-red-200">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 blood-gradient rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-4 red-glow">
                        <i class="fas fa-users text-white text-lg sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-bold text-red-600 mb-1 sm:mb-2">1000+</div>
                    <div class="text-red-700 font-medium text-xs sm:text-base">Donor Aktif</div>
                </div>
                
                <div class="red-gradient-light rounded-2xl p-4 sm:p-8 text-center card-hover border border-red-200">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 blood-gradient rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-4 red-glow">
                        <i class="fas fa-tint text-white text-lg sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-bold text-red-600 mb-1 sm:mb-2">5000+</div>
                    <div class="text-red-700 font-medium text-xs sm:text-base">Donasi Selesai</div>
                </div>
                
                <div class="red-gradient-light rounded-2xl p-4 sm:p-8 text-center card-hover border border-red-200">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 blood-gradient rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-4 red-glow">
                        <i class="fas fa-hospital text-white text-lg sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-bold text-red-600 mb-1 sm:mb-2">50+</div>
                    <div class="text-red-700 font-medium text-xs sm:text-base">Rumah Sakit Mitra</div>
                </div>
                
                <div class="red-gradient-light rounded-2xl p-4 sm:p-8 text-center card-hover border border-red-200">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 blood-gradient rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-4 red-glow">
                        <i class="fas fa-life-ring text-white text-lg sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-bold text-red-600 mb-1 sm:mb-2">10000+</div>
                    <div class="text-red-700 font-medium text-xs sm:text-base">Nyawa Terselamatkan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="kontak" class="hero-gradient text-white py-12 sm:py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0">
            <div class="absolute top-10 right-10 w-16 h-16 sm:w-24 sm:h-24 bg-white opacity-5 rounded-full float-animation"></div>
            <div class="absolute bottom-10 left-10 sm:left-20 w-12 h-12 sm:w-16 sm:h-16 bg-white opacity-10 rounded-full float-animation" style="animation-delay: 1s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-6 sm:mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-white/20 backdrop-blur-sm rounded-full mb-2 sm:mb-4 pulse-animation">
                    <i class="fas fa-hands-helping text-xl sm:text-2xl"></i>
                </div>
            </div>
            <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4">Bergabung Bersama Kami Hari Ini</h3>
            <p class="text-base sm:text-xl mb-6 sm:mb-8 text-white/90 max-w-2xl mx-auto px-4">
                Mari bersama-sama membuat perbedaan dalam kehidupan banyak orang melalui donor darah
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center px-4">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-red-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold hover:bg-red-50 transition-all hover:shadow-xl transform hover:scale-105 border-2 border-red-600 hover:border-red-700 text-sm sm:text-base w-full sm:w-auto">
                        <i class="fas fa-user-plus mr-2"></i>Menjadi Donor Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="blood-gradient text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold hover:shadow-xl transition-all transform hover:scale-105 red-glow text-sm sm:text-base w-full sm:w-auto">
                        <i class="fas fa-handshake mr-2"></i>Kerjasama Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-white text-red-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold hover:bg-red-50 transition-all hover:shadow-xl transform hover:scale-105 border-2 border-red-600 hover:border-red-700 text-sm sm:text-base w-full sm:w-auto">
                        <i class="fas fa-tachometer-alt mr-2"></i>Menuju Dashboard
                    </a>
                    <a href="{{ route('collaborations.create') }}" class="blood-gradient text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold hover:shadow-xl transition-all transform hover:scale-105 red-glow text-sm sm:text-base w-full sm:w-auto">
                        <i class="fas fa-handshake mr-2"></i>Minta Kerjasama
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                <div class="max-w-md">
                    <p class="text-gray-400 mb-3 sm:mb-4 text-sm sm:text-base">Bersama Kita Selamatkan Nyawa</p>
                    <div class="flex space-x-3 sm:space-x-4">
                        <a href="#" class="text-gray-400 hover:text-red-400 transition-colors">
                            <i class="fab fa-facebook text-lg sm:text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-400 transition-colors">
                            <i class="fab fa-twitter text-lg sm:text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-400 transition-colors">
                            <i class="fab fa-instagram text-lg sm:text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-400 transition-colors">
                            <i class="fab fa-linkedin text-lg sm:text-xl"></i>
                        </a>
                    </div>
                </div>

                <div class="md:text-right">
                    <h5 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Kontak</h5>
                    <ul class="space-y-2 text-gray-400 text-sm sm:text-base md:inline-block md:text-left">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-red-400 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-base">+62 123 456 789</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-red-400 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-base">pmi@pmi.or.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-red-400 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-base">Jakarta, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-6 sm:mt-8 pt-6 sm:pt-8 text-center">
                <p class="text-gray-400 text-xs sm:text-base">&copy; 2026 Peduli Darah. Hak Cipta Dilindungi.</p>
                <p class="text-gray-500 text-xs sm:text-sm mt-2">Bersama Kita Selamatkan Nyawa</p>
            </div>
        </div>
    </footer>
</div>

<!-- CSS Styles -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Inter', sans-serif; }
    
    /* Red Color Palette */
    :root {
        --red-50: #fef2f2;
        --red-100: #fee2e2;
        --red-200: #fecaca;
        --red-300: #fca5a5;
        --red-400: #f87171;
        --red-500: #ef4444;
        --red-600: #dc2626;
        --red-700: #b91c1c;
        --red-800: #991b1b;
        --red-900: #7f1d1d;
        --blood-red: #dc143c;
        --crimson: #b22222;
        --dark-red: #8b0000;
        --firebrick: #b22222;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, var(--red-500) 0%, var(--red-600) 50%, var(--red-700) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .hero-gradient {
        background: linear-gradient(135deg, var(--red-500) 0%, var(--red-600) 40%, var(--blood-red) 70%, var(--red-700) 100%);
    }
    
    .blood-gradient {
        background: linear-gradient(135deg, var(--blood-red) 0%, var(--crimson) 50%, var(--dark-red) 100%);
    }
    
    .red-gradient-light {
        background: linear-gradient(135deg, var(--red-100) 0%, var(--red-200) 100%);
    }
    
    .red-gradient-dark {
        background: linear-gradient(135deg, var(--red-700) 0%, var(--red-800) 100%);
    }
    
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(220, 38, 38, 0.15), 0 10px 10px -5px rgba(220, 38, 38, 0.1);
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }
    
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .blood-drop {
        background: var(--blood-red);
        clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
    }
    
    .red-glow {
        box-shadow: 0 0 20px rgba(220, 38, 38, 0.3);
    }
    
    .red-text-gradient {
        background: linear-gradient(45deg, var(--red-500), var(--blood-red), var(--crimson));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Mobile-specific optimizations */
    @media (max-width: 640px) {
        .hero-gradient {
            padding-bottom: 180px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('nav a[href^="#"]');
    
    function setActiveLink(clickedLink) {
        navLinks.forEach(link => {
            link.className = 'text-gray-700 hover:text-red-600 font-medium transition-colors';
        });
        clickedLink.className = 'text-red-600 font-semibold border-b-2 border-red-600 pb-1';
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            setActiveLink(this);
        });
    });

    // Intersection Observer to update active class on scroll
    const sections = document.querySelectorAll('section[id]');
    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                const correspondingLink = document.querySelector(`nav a[href="#${id}"]`);
                if (correspondingLink) {
                    setActiveLink(correspondingLink);
                }
            }
        });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
});
</script>
@endsection
