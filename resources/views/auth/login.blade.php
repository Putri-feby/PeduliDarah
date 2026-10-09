<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peduli Darah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        
        .blood-gradient {
            background: linear-gradient(135deg, var(--red-500) 0%, var(--red-600) 40%, var(--blood-red) 70%, var(--red-700) 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--red-500) 0%, var(--red-600) 50%, var(--red-700) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .red-glow {
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.3);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(220, 38, 38, 0.15), 0 10px 10px -5px rgba(220, 38, 38, 0.1);
        }
    </style>
</head>
<body class="min-h-[70vh] flex items-center justify-center bg-gradient-to-br from-red-50 via-white to-red-50 py-6 px-3 sm:py-8 sm:px-6 lg:px-8">
    <style>
        html { font-size: 90%; }
    </style>
    <!-- Background Decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-20 w-32 h-32 bg-red-200 rounded-full opacity-20 float-animation"></div>
        <div class="absolute bottom-20 right-20 w-40 h-40 bg-red-300 rounded-full opacity-10 float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-red-100 rounded-full opacity-15 float-animation" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="relative z-10 max-w-md w-full">
        <!-- Logo Section -->
        <div class="text-center mb-6">
            <div class="flex items-center justify-center mb-4">
                <img src="{{ asset('images/logo-pmi.svg') }}" alt="Palang Merah Indonesia" class="h-20 w-auto">
            </div>
            <p class="text-gray-600 text-sm sm:text-base">Selamat datang di sistem donor darah!</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-red-100 p-4 sm:p-6 card-hover">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 sm:mb-6 bg-green-50 border border-green-200 rounded-xl p-3 sm:p-4 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2 sm:mr-3 text-lg sm:text-xl"></i>
                    <div>
                        <p class="text-green-800 font-medium text-sm sm:text-base">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            
            <div class="text-center mb-4 sm:mb-6">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Masuk ke Akun
                </h2>
                <p class="text-sm text-gray-600">
                    Akses sistem donor darah
                </p>
            </div>
            
            <form id="loginForm" class="space-y-4" action="{{ route('login') }}" method="POST" onsubmit="return validateForm()" novalidate>
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">
                            <i class="fas fa-envelope mr-1 text-red-500"></i>Email
                        </label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" 
                               class="block w-full px-3 py-2 border-2 border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
                               placeholder="nama@email.com" oninput="validateEmail(this)">
                        <div id="emailWarning" class="mt-1 flex items-center text-red-500 text-xs" style="display: none;">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span>Format email tidak valid</span>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                            <i class="fas fa-lock mr-1 text-red-500"></i>Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required value="{{ old('password') }}" 
                                   class="block w-full px-3 py-2 pr-10 border-2 border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-red-300"
                                   placeholder="••••••••" oninput="validatePassword(this)">
                            <button type="button" onclick="togglePassword('password', this)" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors cursor-pointer focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordLengthWarning" class="mt-1 flex items-center text-red-500 text-xs" style="display: none;">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span>Password minimal 8 karakter.</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border-2 border-transparent text-sm font-semibold rounded-xl text-white blood-gradient hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:scale-105 red-glow">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </div>

                <div class="text-center pt-4">
                    <span class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-semibold text-red-600 hover:text-red-500 transition-colors">
                            Daftar
                        </a>
                    </span>
                </div>
            </form>
        </div>
        
        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                <i class="fas fa-shield-alt mr-1 text-red-400"></i>
                Data Anda aman dan terlindungi
            </p>
        </div>
    </div>

    <script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function validateEmail(input) {
        if (typeof Swal !== 'undefined' && Swal.isVisible()) {
            Swal.close();
        }
        
        const emailWarning = document.getElementById('emailWarning');
        const value = input.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (value.length > 0 && !emailRegex.test(value)) {
            emailWarning.style.display = 'flex';
            input.classList.add('border-red-500');
            return false;
        } else {
            emailWarning.style.display = 'none';
            input.classList.remove('border-red-500');
            return true;
        }
    }

    function validatePassword(input) {
        if (typeof Swal !== 'undefined' && Swal.isVisible()) {
            Swal.close();
        }

        const lengthWarning = document.getElementById('passwordLengthWarning');
        const value = input.value;
        let isValid = true;

        if (value.length > 0 && value.length < 8) {
            lengthWarning.style.display = 'flex';
            isValid = false;
        } else {
            lengthWarning.style.display = 'none';
        }

        if (!isValid && value.length > 0) {
            input.classList.add('border-red-500');
        } else {
            input.classList.remove('border-red-500');
        }
        
        if (value.length === 0) isValid = false;
        
        return isValid;
    }

    function validateForm() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        // Execute both to show warnings if needed
        const isEmailValid = emailInput.value.length === 0 ? false : validateEmail(emailInput);
        const isPasswordValid = passwordInput.value.length === 0 ? false : validatePassword(passwordInput);
        
        if (emailInput.value.length === 0 || passwordInput.value.length === 0) {
            return true; // Let native HTML validation handle "required" empty fields
        }

        if (!isEmailValid || !isPasswordValid) {
            Swal.fire({
                title: 'Validasi Gagal!',
                text: 'Silakan periksa kembali email dan password yang Anda masukkan sesuai format.',
                icon: 'warning',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#dc2626'
            });
            return false;
        }
        
        return true;
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Login Gagal',
                text: '{!! addslashes($errors->first()) !!}',
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        });
    @endif
    </script>
</body>
</html>
