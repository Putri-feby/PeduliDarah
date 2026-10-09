@extends('layouts.app')

@section('title', 'Donor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome Section -->
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ auth()->user()->nama_lengkap }}!</h1>
            <p class="text-red-100">Kelola aktivitas donor darah Anda</p>
        </div>
        <div class="hidden md:block">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                <i class="fas fa-heart text-3xl"></i>
            </div>
        </div>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 red-gradient-light rounded-xl flex items-center justify-center red-glow">
                        <i class="fas fa-clipboard-list text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500">Total Pendaftaran</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $registrations->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 red-gradient-light rounded-xl flex items-center justify-center red-glow">
                        <i class="fas fa-check-circle text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500">Donasi Selesai</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $registrations->where('status', 'completed')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 red-gradient-light rounded-xl flex items-center justify-center red-glow">
                        <i class="fas fa-calendar-check text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500">Akan Datang</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $registrations->where('status', 'registered')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-5 border-b border-red-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Pendaftaran Terbaru</h3>
                    <p class="text-sm text-gray-600 mt-1">Riwayat pendaftaran donor darah Anda</p>
                </div>
                <div class="hidden sm:block">
                    <i class="fas fa-history text-red-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            @if($registrations->count() > 0)
                <div class="space-y-4">
                    @foreach($registrations as $registration)
                        <div class="bg-gray-50 rounded-xl p-4 hover:bg-red-50 transition-colors border border-gray-200 hover:border-red-200">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ $registration->schedule->title }}
                                        </h4>
                                        <div class="ml-2 flex-shrink-0">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $registration->status == 'completed' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                                   ($registration->status == 'confirmed' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                                                   'bg-yellow-100 text-yellow-800 border border-yellow-200') }}">
                                                <i class="fas fa-{{ $registration->status == 'completed' ? 'check' : 
                                                              ($registration->status == 'confirmed' ? 'clock' : 'hourglass-half') }} mr-1"></i>
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-red-400 mr-2"></i>
                                            {{ $registration->schedule->start_time->format('d M Y, H:i') }}
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-red-400 mr-2"></i>
                                            {{ $registration->schedule->location }}
                                        </div>
                                    </div>
                                    
                                    @if($registration->queue)
                                        <div class="mt-3 flex items-center text-sm">
                                            <i class="fas fa-sort-numeric-up text-red-400 mr-2"></i>
                                            <span class="font-medium text-gray-700">Nomor Antrian: </span>
                                            <span class="ml-1 px-2 py-1 bg-red-100 text-red-800 rounded-lg font-bold">#{{ $registration->queue->queue_number }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-4 sm:mt-0 sm:ml-4 flex flex-wrap gap-2 sm:gap-0 sm:space-x-2">
                                    @if($registration->eTicket)
                                        <a href="{{ route('donor.eticket.show', $registration) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-xs font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 transition-colors">
                                            <i class="fas fa-ticket-alt mr-1"></i>
                                            E-Ticket
                                        </a>
                                    @endif
                                    @if($registration->queue)
                                        <a href="{{ route('donor.queue.show', $registration->schedule) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-xs font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 transition-colors">
                                            <i class="fas fa-users mr-1"></i>
                                            Antrian
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-red-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pendaftaran</h3>
                    <p class="text-gray-600 mb-6">Mulai dengan mendaftar untuk jadwal donor darah.</p>
                    <a href="{{ route('donor.schedules.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white blood-gradient hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:scale-105 red-glow">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Lihat Jadwal Tersedia
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.15), 0 4px 6px -2px rgba(220, 38, 38, 0.1);
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }
    
    .red-gradient-light {
        background: linear-gradient(135deg, var(--red-100) 0%, var(--red-200) 100%);
    }
    
    .blood-gradient {
        background: linear-gradient(135deg, var(--red-500) 0%, var(--red-600) 40%, var(--blood-red) 70%, var(--red-700) 100%);
    }
    
    .red-glow {
        box-shadow: 0 0 20px rgba(220, 38, 38, 0.3);
    }
    
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
</style>
@endsection
