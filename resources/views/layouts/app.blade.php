<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>@yield('title', 'Peduli Darah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px; /* Adjust for fixed header */
        }
        body { 
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #374151;
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
        }
        
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
        
        /* Desktop-specific improvements */
        @media (min-width: 1024px) {
            body {
                font-size: 14px;
            }
            
            .desktop-nav-text {
                font-size: 12px;
                font-weight: 400;
            }
        }
        
        /* Mobile-specific improvements */
        @media (max-width: 640px) {
            body {
                font-size: 16px;
            }
            
            .sidebar-mobile {
                width: 100%;
                max-width: 280px;
            }
            
            .mobile-menu-btn {
                padding: 12px 16px;
                font-size: 14px;
                -webkit-tap-highlight-color: transparent;
            }
            
            .mobile-nav-text {
                font-size: 13px;
                line-height: 1.4;
            }
            
            /* Improve touch targets */
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }
        
        @media (max-width: 768px) {
            .mobile-header-spacing {
                padding: 0.75rem 1rem;
            }
            
            .mobile-content-padding {
                padding: 1rem;
            }
        }
        
        /* iOS-specific styling */
        @supports (-webkit-touch-callout: none) {
            .ios-safe-bottom {
                padding-bottom: env(safe-area-inset-bottom);
            }
            
            .ios-safe-top {
                padding-top: env(safe-area-inset-top);
            }
        }
        
        /* Android-specific styling */
        @media screen and (-webkit-device-pixel-ratio: 0) {
            .android-ripple {
                position: relative;
                overflow: hidden;
            }
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--red-500) 0%, var(--red-600) 50%, var(--red-700) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .blood-gradient {
            background: linear-gradient(135deg, var(--blood-red) 0%, var(--crimson) 50%, var(--dark-red) 100%);
        }
        
        .red-gradient-light {
            background: linear-gradient(135deg, var(--red-100) 0%, var(--red-200) 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.15), 0 4px 6px -2px rgba(220, 38, 38, 0.1);
        }
        
        .red-glow {
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.3);
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body {
            overflow-x: hidden;
        }
        
        /* Prevent text selection on mobile */
        .no-select {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
</head>
<body class="bg-gray-50 ios-safe-bottom">
    @auth
        <!-- Header -->
        <header class="bg-white shadow-md fixed w-full top-0 z-50 ios-safe-top">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
                <div class="flex justify-between h-16">
                    <div class="flex items-center justify-start w-1/3 sm:w-1/4">
                        <div class="flex items-center space-x-1 sm:space-x-2 ml-0">
                            <button onclick="toggleSidebar()" class="lg:hidden bg-red-600 text-white p-2 rounded-lg shadow-lg mobile-menu-btn no-select">
                                <i class="fas fa-bars"></i>
                            </button>
                            <a href="{{ auth()->check() ? route('dashboard') : '/' }}" class="flex items-center">
                                <img src="{{ asset('images/logo-pmi.svg') }}" alt="Palang Merah Indonesia" class="h-9 sm:h-11 w-auto">
                            </a>
                        </div>
                    </div>
                    <nav class="flex items-center space-x-1 sm:space-x-4 ml-auto">
                        <span class="text-xs sm:text-sm text-gray-700 font-medium">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</span>

                        @if(!auth()->user()->isAdmin())
                        {{-- Donor: clickable badge with profile dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="hidden sm:inline-flex items-center text-xs bg-red-600 text-white px-3 py-1.5 rounded-full font-medium hover:bg-red-700 transition-colors focus:outline-none shadow-sm cursor-pointer select-none">
                                <i class="fas fa-user mr-1 text-xs"></i>
                                <span>{{ ucfirst(auth()->user()->role) }}</span>
                                <i class="fas fa-chevron-down ml-1.5 text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                                 style="display:none;">

                                {{-- User info header --}}
                                <div class="px-4 py-3 bg-gradient-to-br from-red-600 to-red-700 text-white">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user text-white text-base"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-sm truncate">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</p>
                                            <p class="text-xs text-red-100 truncate">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Profile link --}}
                                <div class="py-1">
                                    <a href="{{ route('donor.profile') }}"
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors group">
                                        <span class="w-8 h-8 rounded-full bg-red-100 group-hover:bg-red-200 flex items-center justify-center mr-3 flex-shrink-0 transition-colors">
                                            <i class="fas fa-id-card text-red-600 text-xs"></i>
                                        </span>
                                        <div>
                                            <p class="font-medium leading-tight">Lihat Detail Profil</p>
                                            <p class="text-xs text-gray-400">Data pribadi &amp; riwayat donor</p>
                                        </div>
                                        <i class="fas fa-chevron-right ml-auto text-xs text-gray-300 group-hover:text-red-400"></i>
                                    </a>
                                </div>

                                <div class="border-t border-gray-100"></div>

                                {{-- Logout inside dropdown --}}
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors group">
                                            <span class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-red-100 flex items-center justify-center mr-3 flex-shrink-0 transition-colors">
                                                <i class="fas fa-sign-out-alt text-gray-500 group-hover:text-red-600 text-xs"></i>
                                            </span>
                                            <span class="font-medium">Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        {{-- Admin: static badge --}}
                        <span class="hidden sm:inline-flex items-center text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full font-medium">
                            <i class="fas fa-user-shield mr-1 text-xs"></i>
                            <span>{{ ucfirst(auth()->user()->role) }}</span>
                        </span>
                        @endif

                        <!-- Notifications Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-500 hover:text-red-600 focus:outline-none relative">
                                <i class="fas fa-bell text-lg"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-20 border border-gray-200" style="display: none;">
                                <div class="py-2">
                                    <div class="px-4 py-2 font-bold text-gray-800 border-b">Notifikasi</div>
                                    <div class="max-h-64 overflow-y-auto">
                                        @forelse(auth()->user()->notifications as $notification)
                                            <div class="px-4 py-3 border-b hover:bg-gray-50 {{ $notification->read_at ? 'bg-white' : 'bg-red-50' }}">
                                                <p class="text-sm font-medium text-gray-800">{{ $notification->data['message'] ?? 'Notifikasi' }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $notification->data['description'] ?? '' }}</p>
                                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                @if(!$notification->read_at)
                                                    <a href="{{ route('notifications.read', $notification->id) }}" class="text-xs text-red-600 hover:text-red-800 mt-2 inline-block">Tandai sudah dibaca</a>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="px-4 py-3 text-sm text-gray-500 text-center">Belum ada notifikasi</div>
                                        @endforelse
                                    </div>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <div class="px-4 py-2 border-t text-center">
                                            <a href="{{ route('notifications.readAll') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">Tandai semua sudah dibaca</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Standalone logout only for admin --}}
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-xs sm:text-sm min-h-[44px] min-w-[44px] flex items-center justify-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <div class="flex pt-16 overflow-x-hidden">
            <!-- Sidebar -->
            <aside id="sidebar" class="w-64 bg-white shadow-lg h-screen fixed left-0 top-16 border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-30 sidebar-mobile flex-shrink-0">
                <nav class="p-4 space-y-2">
                    @if(auth()->user()->isAdmin())
                        <!-- Admin Navigation -->
                        <a href="{{ route('admin.schedules.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-calendar-alt text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Manajemen Jadwal</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Jadwal</h1>
                        </a>
                        <a href="{{ route('admin.registrations.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-users text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Pendaftaran</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Registrasi</h1>
                        </a>

                        <a href="{{ route('admin.collaborations.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-handshake text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Kerjasama</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Kerjasama</h1>
                        </a>
                        <a href="{{ route('admin.tickets.scan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-qrcode text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Scan Tiket</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Scan Tiket</h1>
                        </a>
                    @else
                        <!-- Donor Navigation -->
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-tachometer-alt text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Dashboard</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Dashboard</h1>
                        </a>
                        <a href="{{ route('donor.schedules.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-calendar-alt text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Jadwal Donor</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Jadwal</h1>
                        </a>
                        <a href="{{ route('donor.registrations.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-clipboard-list text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Pendaftaran</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Pendaftaran</h1>
                        </a>
                        <a href="{{ route('donor.tickets.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-ticket-alt text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Tiket</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Tiket</h1>
                        </a>
                        <a href="{{ route('donor.collaborations') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-700 hover:text-red-600 min-h-[44px]">
                            <i class="fas fa-handshake text-sm"></i>
                            <span class="hidden lg:inline text-xs lg:text-sm mobile-nav-text">Kolaborasi</span>
                            <h1 class="text-lg font-bold gradient-text sm:hidden">Kolaborasi</h1>
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ml-0 lg:ml-64 p-4 sm:p-6 mobile-content-padding overflow-x-hidden min-w-0">
                <div class="p-3 sm:p-4 w-full overflow-hidden">
                    @if(session('success'))
                        <div class="mb-3 bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded-lg text-xs sm:text-sm">
                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-3 bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-lg text-xs sm:text-sm">
                            <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                
                // Prevent body scroll when sidebar is open on mobile
                if (!sidebar.classList.contains('-translate-x-full')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isMenuButton = event.target.closest('button[onclick="toggleSidebar()"]');
                
                if (!isClickInsideSidebar && !isMenuButton && window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
            
            // Handle resize events
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        </script>

        <!-- OneSignal Web Push Integration -->
        <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
        <script>
            window.OneSignalDeferred = window.OneSignalDeferred || [];
            OneSignalDeferred.push(async function(OneSignal) {
                await OneSignal.init({
                    appId: "{{ env('ONESIGNAL_APP_ID') }}",
                    safari_web_id: "", // Tambahkan jika Anda men-setup Safari Web Push
                    notifyButton: {
                        enable: true,
                        size: 'medium',
                        theme: 'default',
                        position: 'bottom-right',
                        text: {
                            'tip.state.unsubscribed': 'Berlangganan Notifikasi',
                            'tip.state.subscribed': 'Anda berlangganan notifikasi',
                            'tip.state.blocked': 'Anda memblokir notifikasi',
                            'message.prenotify': 'Klik untuk berlangganan notifikasi panggilan antrean',
                            'message.action.subscribed': 'Terima kasih telah berlangganan!',
                            'message.action.resubscribed': 'Anda telah berlangganan kembali',
                            'message.action.unsubscribed': 'Anda batal berlangganan notifikasi',
                        }
                    },
                });

                // Link this user's Laravel ID to OneSignal external_id
                @auth
                    OneSignal.login("{{ auth()->id() }}");
                @endauth

                // Listen for foreground notifications to show popup instantly
                OneSignal.Notifications.addEventListener('foregroundWillDisplay', function(event) {
                    const notification = event.notification;
                    
                    // Show custom in-app toast notification
                    const toastDiv = document.createElement('div');
                    toastDiv.className = 'fixed bottom-4 right-4 bg-white border-l-4 border-red-500 rounded-lg shadow-2xl p-4 z-[100] transform transition-all duration-500 translate-y-full flex items-start max-w-sm';
                    toastDiv.innerHTML = `
                        <div class="flex-shrink-0 pt-1">
                            <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-bell text-red-500"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-bold text-gray-900">${notification.title || 'Notifikasi'}</h3>
                            <p class="mt-1 text-sm text-gray-600">${notification.body || ''}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none" onclick="this.parentElement.parentElement.remove()">
                                <span class="sr-only">Close</span>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    document.body.appendChild(toastDiv);
                    
                    // Animate in
                    setTimeout(() => {
                        toastDiv.classList.remove('translate-y-full');
                    }, 100);

                    // Remove after 10 seconds
                    setTimeout(() => {
                        toastDiv.classList.add('translate-y-full');
                        setTimeout(() => toastDiv.remove(), 500);
                    }, 10000);

                    // Also show the full popup if they are on the queue page and it's their turn
                    const popup = document.getElementById('calledPopup');
                    if (popup && notification.title === 'Panggilan Antrean') {
                        popup.classList.remove('hidden');
                    }
                });
            });
        </script>
        <!-- Global Called Popup -->
        <div id="calledPopup" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full mx-4 transform transition-all text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4 animate-pulse">
                        <i class="fas fa-bullhorn text-yellow-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Panggilan Antrean!</h3>
                    <p class="text-base text-gray-600 mb-6">
                        Silakan menuju ruang donor darah.
                    </p>
                    <button onclick="document.getElementById('calledPopup').classList.add('hidden')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:text-sm">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>

        <script>
            @auth
                document.addEventListener('DOMContentLoaded', function() {
                    let queueId = null;
                    
                    function checkQueue() {
                        fetch(`/api/my-active-queue`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.queue && data.queue.status === 'called') {
                                    queueId = data.queue.id;
                                    if (!sessionStorage.getItem('called_popup_shown_' + queueId)) {
                                        document.getElementById('calledPopup').classList.remove('hidden');
                                        if ('Notification' in window && Notification.permission === 'granted') {
                                            new Notification('Panggilan Antrean', {
                                                body: 'Silakan menuju ruang donor darah.',
                                            });
                                        }
                                        sessionStorage.setItem('called_popup_shown_' + queueId, 'true');
                                    }
                                }
                            })
                            .catch(err => console.error('Error fetching global queue status:', err));
                    }

                    // Check on load
                    checkQueue();

                    // Poll every 5 seconds
                    setInterval(checkQueue, 5000);
                });
            @endauth
        </script>
    @else
        <main class="min-h-screen">
            @yield('content')
        </main>
    @endauth
</body>
</html>
