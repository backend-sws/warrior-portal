@extends('layouts.parent')

@section('content')
<div class="py-12 sm:px-6 lg:px-8 flex justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl p-8 sm:p-12 relative overflow-hidden">
        
        <!-- Decorative bg shapes -->
        <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-blue-50 rounded-full opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 bg-purple-50 rounded-full opacity-50 pointer-events-none"></div>

        <div class="text-center mb-10 relative z-10">
            <h1 class="text-3xl font-extrabold text-[#031b4e] mb-3">Need a Tutor for Your Child?</h1>
            <p class="text-gray-500 text-sm">Fill this quick form and we'll match you with the best verified tutor.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-8 flex items-center border border-green-100 relative z-10">
                <i class="fas fa-check-circle mr-3"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('parent.tuitions.store') }}" method="POST" class="space-y-6 relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-2">Your Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none"
                        placeholder="Enter your full name">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-2">Your Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none"
                        placeholder="Enter your phone number">
                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Class -->
                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-2">Student's Class <span class="text-red-500">*</span></label>
                    <input type="text" name="class" placeholder="e.g. Class 10" required value="{{ old('class') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none bg-white text-gray-700">
                    @error('class') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Board -->
                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-2">Board <span class="text-red-500">*</span></label>
                    <select name="board" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none bg-white text-gray-700">
                        <option value="">Select Board</option>
                        @foreach(['CBSE', 'ICSE', 'State Board', 'IGCSE', 'IB', 'Other'] as $board)
                            <option value="{{ $board }}" {{ old('board') == $board ? 'selected' : '' }}>{{ $board }}</option>
                        @endforeach
                    </select>
                    @error('board') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Subjects -->
            <div>
                <label class="block text-sm font-bold text-[#031b4e] mb-2">Subjects Needed <span class="text-red-500">*</span></label>
                <input type="text" name="subjects" value="{{ old('subjects') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none"
                    placeholder="e.g., Math, Science">
                @error('subjects') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-bold text-[#031b4e] mb-2">Complete Location/Address <span class="text-red-500">*</span></label>
                <input type="text" name="location" value="{{ old('location') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none"
                    placeholder="Enter full address or area">
                @error('location') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-[#031b4e] mb-2">Pincode <span class="text-red-500">*</span></label>
                <input type="text" name="pincode" value="{{ old('pincode') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0ea5e9] focus:ring-2 focus:ring-[#0ea5e9]/20 transition-all outline-none"
                    placeholder="Enter 6-digit Pincode">
                @error('pincode') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-center">
                <button type="submit"
                    class="px-8 py-3.5 bg-[#031b4e] text-white font-bold rounded-full hover:bg-[#031b4e]/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                    Post Requirement <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
