@extends('layouts.admin')

@section('title', 'Post Tuition Requirement')
@section('subtitle', 'Add a new home tuition requirement manually.')

@section('actions')
    <a href="{{ route('admin.tuitions.index') }}" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Back to Tuitions
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 max-w-4xl mx-auto">
    <form action="{{ route('admin.tuitions.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Class -->
            <div>
                <label for="student_class" class="block text-sm font-medium text-gray-700 mb-2">Student's Class/Grade <span class="text-red-500">*</span></label>
                <select name="student_class" id="student_class" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-colors outline-none">
                    <option value="">Select Class</option>
                    <option value="Pre-Primary">Pre-Primary</option>
                    <option value="Class 1-5">Class 1 to 5</option>
                    <option value="Class 6-8">Class 6 to 8</option>
                    <option value="Class 9-10">Class 9 to 10</option>
                    <option value="Class 11-12">Class 11 to 12</option>
                    <option value="College/University">College/University</option>
                </select>
                @error('student_class')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Board -->
            <div>
                <label for="board" class="block text-sm font-medium text-gray-700 mb-2">Board <span class="text-red-500">*</span></label>
                <select name="board" id="board" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-colors outline-none">
                    <option value="">Select Board</option>
                    <option value="CBSE">CBSE</option>
                    <option value="ICSE">ICSE</option>
                    <option value="State Board">State Board</option>
                    <option value="IGCSE/IB">IGCSE/IB</option>
                    <option value="Other">Other</option>
                </select>
                @error('board')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subjects -->
            <div>
                <label for="subjects" class="block text-sm font-medium text-gray-700 mb-2">Subjects Needed <span class="text-red-500">*</span></label>
                <input type="text" name="subjects" id="subjects" placeholder="e.g., Mathematics, Science, English" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-colors outline-none">
                @error('subjects')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Budget -->
            <div>
                <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">Monthly Budget (₹) <span class="text-red-500">*</span></label>
                <input type="text" name="budget" id="budget" placeholder="e.g., 2000-5000" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-colors outline-none">
                @error('budget')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Location -->
        <div class="mb-6">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Complete Location <span class="text-red-500">*</span></label>
            <input type="text" name="location" id="location" placeholder="e.g., Kankarbagh, Patna, Bihar - 800020" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-colors outline-none">
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-8">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Specific Requirements (Optional)</label>
            <textarea name="description" id="description" rows="4" placeholder="Any specific requirements like 'Need a female tutor', 'Available only in evenings', etc." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-colors outline-none"></textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4">
            <button type="submit" class="bg-accent-blue hover:bg-accent-blue/90 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-md transition-all flex items-center gap-2">
                <i class="fas fa-check"></i> Post Tuition Requirement
            </button>
        </div>
    </form>
</div>
@endsection
