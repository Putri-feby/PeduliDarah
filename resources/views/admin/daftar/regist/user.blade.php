@extends('layouts.app')

@section('title', 'Registration Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Registration Management</h1>
                <p class="text-red-100">Kelola pendaftaran donor darah</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center pulse-animation">
                    <i class="fas fa-users text-3xl"></i>
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
                            <i class="fas fa-list text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Registrations</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $registrations->count() }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $registrations->where('status', 'pending')->count() }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Confirmed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $registrations->where('status', 'confirmed')->count() }}</dd>
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
                            <i class="fas fa-calendar text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $registrations->where('status', 'completed')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registrations List -->
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
        <div class="px-6 py-5">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">All Registrations</h3>
                    <p class="mt-1 text-sm text-gray-500">Manage blood donation registrations</p>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200">
            @if($registrations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Donor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Schedule
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registration Time
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($registrations as $registration)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-red-600">
                                                        {{ strtoupper(substr($registration->user->nama_lengkap, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $registration->user->nama_lengkap }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $registration->user->email }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $registration->user->no_telp ?: 'No phone' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $registration->schedule->title }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $registration->schedule->location }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $registration->schedule->start_time->format('M d, Y - H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $registration->registration_time->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $registration->registration_time->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $registration->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($registration->status == 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($registration->status == 'completed' ? 'bg-blue-100 text-blue-800' : 
                                               'bg-red-100 text-red-800')) }}">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($registration->status == 'pending')
                                            <form action="{{ route('admin.registrations.confirm', $registration) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                                    <i class="fas fa-check"></i> Confirm
                                                </button>
                                            </form>
                                        @endif
                                        @if($registration->eTicket)
                                            <a href="{{ route('donor.eticket.show', $registration->eTicket) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-3" target="_blank">
                                                <i class="fas fa-ticket-alt"></i> E-Ticket
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.queue.manage', $registration->schedule) }}" 
                                           class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-users"></i> Antrian
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-users text-gray-400 text-5xl mb-4"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No registrations found</h3>
                    <p class="mt-1 text-sm text-gray-500">No blood donation registrations have been made yet.</p>
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
