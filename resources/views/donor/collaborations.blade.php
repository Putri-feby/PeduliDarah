@extends('layouts.app')

@section('title', 'Kerjasama Saya')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Kerjasama</h1>
                <p class="text-gray-600">Riwayat Pendaftaran</p>
            </div>
            <a href="{{ route('donor.collaboration-request') }}" class="blood-gradient text-white px-6 py-3 rounded-lg hover:shadow-xl transition-all transform hover:scale-105 red-glow">
                <i class="fas fa-plus mr-2"></i>Ajukan Kolaborasi
            </a>
        </div>
    </div>

    <!-- Collaborations List -->
    @if($collaborations->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($collaborations as $collaboration)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 red-gradient-light rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-red-600"></i>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $collaboration->status === 'approved' ? 'bg-green-100 text-green-800' : 
                               ($collaboration->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                               'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($collaboration->status ?? 'pending') }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $collaboration->organization_name ?: $collaboration->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $collaboration->proposal_description ?: $collaboration->description }}</p>
                    
                    <div class="space-y-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-red-400"></i>
                            {{ $collaboration->proposed_date ? $collaboration->proposed_date->format('M d, Y') : $collaboration->created_at->format('M d, Y') }}
                        </div>
                        @if($collaboration->location)
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-red-400"></i>
                                {{ $collaboration->location }}
                            </div>
                        @endif
                        @if($collaboration->expected_donors)
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2 text-red-400"></i>
                                {{ $collaboration->expected_donors }} target pendonor
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                {{ $collaboration->created_at->format('M d, Y') }}
                            </span>
                            <div class="flex space-x-3">
                                @if($collaboration->status === 'pending')
                                    <form action="{{ route('donor.collaborations.destroy', $collaboration) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                            Batal
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('donor.collaborations.show', $collaboration) }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-20 h-20 red-gradient-light rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-handshake text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pendaftaran</h3>
            <p class="text-gray-600 mb-6">Mulai dengan mengajukan kerjasama dengan kami</p>
            <a href="{{ route('donor.collaboration-request') }}" class="blood-gradient text-white px-6 py-3 rounded-lg hover:shadow-xl transition-all transform hover:scale-105 red-glow">
                <i class="fas fa-plus mr-2"></i>Ajukan Kolaborasi
            </a>
        </div>
    @endif
</div>

<style>
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.15), 0 4px 6px -2px rgba(220, 38, 38, 0.1);
    }
    
    .red-gradient-light {
        background: linear-gradient(135deg, var(--red-100) 0%, var(--red-200) 100%);
    }
    
    .blood-gradient {
        background: linear-gradient(135deg, var(--blood-red) 0%, var(--crimson) 50%, var(--dark-red) 100%);
    }
    
    .red-glow {
        box-shadow: 0 0 20px rgba(220, 38, 38, 0.3);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
