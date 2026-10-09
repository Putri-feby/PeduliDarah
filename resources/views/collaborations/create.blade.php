@extends('layouts.app')

@section('title', 'Collaboration Request')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Request Collaboration</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Partner with us for blood donation events and activities
                </p>
            </div>
            <form action="{{ route('collaborations.store') }}" method="POST" class="px-4 py-5 sm:px-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="organization_name" class="block text-sm font-medium text-gray-700">
                            Organization Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="organization_name" name="organization_name" required
                               value="{{ old('organization_name') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('organization_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-gray-700">
                            Contact Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="contact_person" name="contact_person" required
                               value="{{ old('contact_person') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('contact_person') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="contact_email" name="contact_email" required
                               value="{{ old('contact_email') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('contact_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="contact_phone" name="contact_phone" required
                               value="{{ old('contact_phone') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('contact_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="proposed_date" class="block text-sm font-medium text-gray-700">
                            Proposed Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="proposed_date" name="proposed_date" required
                               value="{{ old('proposed_date') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('proposed_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="expected_donors" class="block text-sm font-medium text-gray-700">
                            Expected Number of Donors
                        </label>
                        <input type="number" id="expected_donors" name="expected_donors" min="1"
                               value="{{ old('expected_donors') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('expected_donors') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">
                        Proposed Location
                    </label>
                    <input type="text" id="location" name="location"
                           value="{{ old('location') }}"
                           placeholder="Enter the proposed venue or location"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="proposal_description" class="block text-sm font-medium text-gray-700">
                        Proposal Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="proposal_description" name="proposal_description" rows="4" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              placeholder="Describe your collaboration proposal, event details, and how you'd like to partner with us...">{{ old('proposal_description') }}</textarea>
                    @error('proposal_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="/" 
                       class="bg-gray-300 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
