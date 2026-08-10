@extends('layouts.parent')

@section('content')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 max-w-2xl">
        @if(session('success'))
            <div class="mb-4 bg-green-50 text-green-600 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('parent.profile.update') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" value="{{ auth()->user()->parentProfile->address ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" value="{{ auth()->user()->parentProfile->city ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-[#1e3a8a] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#1e3a8a]/90">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
