@extends('layouts.admin')

@section('title', 'Add Payment Account')
@section('subtitle', 'Create a new tuition fee profile to track dues, collections and follow-ups.')

@section('actions')
    <a href="{{ route('admin.tuition-fees.index') }}" class="bg-secondary-bg border border-card-border text-text-main px-4 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2 text-sm shadow-xs">
        <i class="fas fa-arrow-left text-xs"></i> <span>Back to Accounts</span>
    </a>
@endsection

@section('content')

<form action="{{ route('admin.tuition-fees.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-card-border p-6 sm:p-8 w-full">
    @csrf

    @if ($errors->any())
        <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 border border-red-200">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-8">
        <!-- Student Info Section -->
        <div>
            <div class="flex items-center gap-2 pb-3 mb-5 border-b border-card-border">
                <div class="w-8 h-8 rounded-lg bg-accent-blue/10 text-accent-blue flex items-center justify-center text-sm">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="text-sm font-black text-text-main uppercase tracking-wider">Student & Parent Information</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Student Name <span class="text-red-500">*</span></label>
                    <input type="text" name="student_name" value="{{ old('student_name', request('student_name')) }}" required placeholder="e.g. Rahul Sharma"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Parent Name <span class="text-red-500">*</span></label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', request('parent_name')) }}" required placeholder="e.g. Ramesh Sharma"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
                    <input type="text" name="mobile_number" value="{{ old('mobile_number', request('mobile_number')) }}" required placeholder="e.g. 9876543210"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Address / Area</label>
                    <input type="text" name="address" value="{{ old('address', request('address')) }}" placeholder="e.g. Kankarbagh, Patna"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>
            </div>
        </div>

        <!-- Tuition Info Section -->
        <div>
            <div class="flex items-center gap-2 pb-3 mb-5 border-b border-card-border">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3 class="text-sm font-black text-text-main uppercase tracking-wider">Tuition Requirement Details</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Class / Standard</label>
                    <input type="text" name="class" value="{{ old('class', request('class')) }}" placeholder="e.g. Class 10th (CBSE)"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Subject(s)</label>
                    <input type="text" name="subject" value="{{ old('subject', request('subject')) }}" placeholder="e.g. Maths, Science, English"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>
            </div>
        </div>

        <!-- Teacher & Fee Section -->
        <div>
            <div class="flex items-center gap-2 pb-3 mb-5 border-b border-card-border">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="text-sm font-black text-text-main uppercase tracking-wider">Teacher Assignment & Fee Structure</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Assigned Teacher</label>
                    <input type="text" name="teacher_name" value="{{ old('teacher_name', request('teacher_name')) }}" placeholder="e.g. Amit Kumar"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Teacher Joining Date <span class="text-red-500">*</span></label>
                    <input type="date" name="teacher_joining_date" value="{{ old('teacher_joining_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                    <p class="text-[11px] text-text-dark/50 mt-1">Due date will automatically be exactly 1 month after joining date.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Monthly Fee (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="monthly_fee" value="{{ old('monthly_fee', request('monthly_fee')) }}" required placeholder="e.g. 4000"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm font-bold focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-card-border flex items-center justify-end gap-3">
        <a href="{{ route('admin.tuition-fees.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm text-text-dark/60 hover:bg-secondary-bg transition-colors">
            Cancel
        </a>
        <button type="submit" class="bg-accent-blue hover:bg-blue-700 text-white px-7 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-accent-blue/20">
            Create Account
        </button>
    </div>
</form>
@endsection
