@extends('layouts.admin')

@section('title', 'Edit Payment Account')
@section('subtitle', 'Update fee profile and due dates for ' . $account->student_name)

@section('actions')
    <a href="{{ route('admin.tuition-fees.show', $account->id) }}" class="bg-secondary-bg border border-card-border text-text-main px-4 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2 text-sm shadow-xs">
        <i class="fas fa-arrow-left text-xs"></i> <span>Back to Account</span>
    </a>
@endsection

@section('content')

<form action="{{ route('admin.tuition-fees.update', $account->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-card-border p-6 sm:p-8 w-full">
    @csrf
    @method('PUT')

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
                    <input type="text" name="student_name" value="{{ old('student_name', $account->student_name) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Parent Name <span class="text-red-500">*</span></label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $account->parent_name) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
                    <input type="text" name="mobile_number" value="{{ old('mobile_number', $account->mobile_number) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Address / Area</label>
                    <input type="text" name="address" value="{{ old('address', $account->address) }}"
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
                    <input type="text" name="class" value="{{ old('class', $account->class) }}" placeholder="e.g. 10th"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Subject(s)</label>
                    <input type="text" name="subject" value="{{ old('subject', $account->subject) }}" placeholder="e.g. Maths, Science"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>
            </div>
        </div>

        <!-- Teacher, Fee & Status Section -->
        <div>
            <div class="flex items-center gap-2 pb-3 mb-5 border-b border-card-border">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="text-sm font-black text-text-main uppercase tracking-wider">Teacher, Fee & Account Status</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Assigned Teacher</label>
                    <input type="text" name="teacher_name" value="{{ old('teacher_name', $account->teacher_name) }}"
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Joining Date <span class="text-red-500">*</span></label>
                    <input type="date" name="teacher_joining_date" value="{{ old('teacher_joining_date', $account->teacher_joining_date ? $account->teacher_joining_date->format('Y-m-d') : '') }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Monthly Fee (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="monthly_fee" value="{{ old('monthly_fee', $account->monthly_fee) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm font-bold focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Account Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                        <option value="active" {{ old('status', $account->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $account->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Next Due Date <span class="text-red-500">*</span></label>
                    <input type="date" name="next_due_date" value="{{ old('next_due_date', $account->next_due_date ? $account->next_due_date->format('Y-m-d') : '') }}" required
                        class="w-full px-4 py-2.5 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-card-border flex items-center justify-end gap-3">
        <a href="{{ route('admin.tuition-fees.show', $account->id) }}" class="px-5 py-2.5 rounded-xl font-bold text-sm text-text-dark/60 hover:bg-secondary-bg transition-colors">
            Cancel
        </a>
        <button type="submit" class="bg-accent-blue hover:bg-blue-700 text-white px-7 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-accent-blue/20">
            Update Account
        </button>
    </div>
</form>
@endsection
