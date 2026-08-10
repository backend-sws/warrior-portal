@extends('layouts.admin')

@section('title', 'Add Payment Account')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-text-main">Add Payment Account</h1>
        <p class="text-text-dark/60 text-sm mt-1">Create a new tuition fee profile for a student.</p>
    </div>
    <a href="{{ route('admin.tuition-fees.index') }}" class="bg-secondary-bg border border-card-border text-text-main px-5 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Accounts
    </a>
</div>

<form action="{{ route('admin.tuition-fees.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-card-border p-6 max-w-3xl">
    @csrf

    @if ($errors->any())
        <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 border border-red-200">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Student Info -->
        <div class="col-span-full">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Student & Parent Information</h3>
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Student Name <span class="text-red-500">*</span></label>
            <input type="text" name="student_name" value="{{ old('student_name') }}" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Parent Name <span class="text-red-500">*</span></label>
            <input type="text" name="parent_name" value="{{ old('parent_name') }}" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
            <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-bold text-text-main mb-1.5">Address</label>
            <textarea name="address" rows="2"
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">{{ old('address') }}</textarea>
        </div>

        <!-- Tuition Info -->
        <div class="col-span-full mt-2">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Tuition Details</h3>
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Class</label>
            <input type="text" name="class" value="{{ old('class') }}" placeholder="e.g. 10th"
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Subject(s)</label>
            <input type="text" name="subject" value="{{ old('subject') }}" placeholder="e.g. Maths, Science"
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div class="col-span-full mt-2">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Teacher & Fee Info</h3>
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Teacher Assigned</label>
            <input type="text" name="teacher_name" value="{{ old('teacher_name') }}"
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Teacher Joining Date <span class="text-red-500">*</span></label>
            <input type="date" name="teacher_joining_date" value="{{ old('teacher_joining_date') }}" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
            <p class="text-xs text-text-dark/50 mt-1">The first due date will automatically be exactly 1 month after this date.</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Monthly Fee (₹) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="monthly_fee" value="{{ old('monthly_fee') }}" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

    </div>

    <div class="mt-8 pt-6 border-t border-card-border flex justify-end">
        <button type="submit" class="bg-accent-blue text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition-colors">
            Create Account
        </button>
    </div>
</form>
@endsection
