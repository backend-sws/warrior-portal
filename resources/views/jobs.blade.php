@extends('layouts.app')
@section('title', 'Teaching Jobs & School Faculty Vacancies in India | Warriors Educare')
@section('meta_description', 'Explore top school and college teaching vacancies across India. Apply for PGT, TGT, PRT, and Principal positions with instant employer matching.')
@section('content')
<x-page-header title="Find Your Dream Role" :breadcrumbs="['Home' => route('home'), 'Jobs' => null]" image="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" />
<div class="py-8 sm:py-12 px-4 sm:px-6 lg:px-[5%] metallic-blue-card border-none shadow-none border-b border-white/10 relative overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>

    <div class="max-w-5xl mx-auto reveal relative z-10">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8 relative overflow-hidden">
            <!-- Subtle accent inside the box -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent-blue/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
            
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-6 sm:mb-8 relative z-10 text-center sm:text-left">Let Your Teaching Career Begin Here</h2>
            
            <form action="{{ route('jobs') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-stretch md:items-end relative z-10">
                @if(request('job_type'))
                    <input type="hidden" name="job_type" value="{{ request('job_type') }}">
                @endif
                <!-- Keyword / Job ID -->
                <div class="flex-1 w-full">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Job ID / Keyword</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Job ID (e.g. JOB-0001) or title..." class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue placeholder:text-slate-400">
                </div>

                <!-- State -->
                <div class="flex-1 w-full">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">State</label>
                    <select name="state" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue appearance-none">
                        <option value="">Select State</option>
                        @foreach($states as $st)
                            <option value="{{ $st->id }}" {{ request('state') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Category -->
                <div class="flex-1 w-full">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Category</label>
                    <select name="class" id="search_category" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue appearance-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('class') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Subject -->
                <div class="flex-1 w-full">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Subject</label>
                    <select name="subject" id="search_subject" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue appearance-none">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->id }}" {{ request('subject') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Specialization (Hidden initially) -->
                <div class="flex-1 w-full" id="specialization_container" style="display: none;">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Specialization</label>
                    <select name="specialization" id="search_specialization" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue appearance-none">
                        <option value="">Select Specialization</option>
                    </select>
                </div>
                
                <!-- Search Button -->
                <div class="w-full md:w-auto flex gap-2 pt-2 md:pt-0">
                    <a href="{{ route('jobs') }}" class="flex-1 md:flex-initial bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl px-6 py-3 font-bold transition-all shadow-sm text-center text-sm active:scale-95">Clear</a>
                    <button type="submit" class="flex-1 md:flex-initial bg-[#031b4e] hover:bg-[#021030] text-white rounded-xl px-7 py-3 font-bold transition-all shadow-md text-sm active:scale-95">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-[5%] bg-white relative overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute inset-0 z-0 opacity-[0.02]" style="background-image: radial-gradient(#000000 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>

    <!-- Job List Container -->
    <div class="max-w-7xl mx-auto relative z-10 w-full">
        @if($jobs->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 flex flex-col justify-between hover:border-accent-blue/50 hover:shadow-xl transition-all duration-300 group reveal">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-graduation-cap text-[#0ea5e9] text-xl"></i>
                                </div>
                                <span class="inline-flex items-center gap-1 font-mono text-[11px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-lg border border-indigo-100">
                                    <i class="fas fa-hashtag text-[8px] opacity-70"></i>{{ $job->job_id ?: 'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <span class="bg-blue-50 text-accent-blue px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">{{ $job->category?->name ?? 'N/A' }}</span>
                        </div>
                        
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1 group-hover:text-accent-blue transition-colors line-clamp-1">
                            <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title ?? 'Job Requirement' }}</a>
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium mb-3 line-clamp-1">
                            <i class="fas fa-shield-alt text-[#0ea5e9] text-[11px] mr-1"></i> Verified Institution • {{ $job->city?->name ?? 'N/A' }}, {{ $job->state?->name ?? 'N/A' }}
                        </p>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5 line-clamp-3">
                            {{ Str::limit(strip_tags($job->description), 100) }}
                        </p>
                        
                        <div class="flex flex-wrap items-center gap-2 mb-5">
                            <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg text-[11px] font-bold text-slate-600 flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-book text-accent-blue"></i> {{ Str::limit($job->subject?->name ?? 'N/A', 15) }}
                            </span>
                            <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg text-[11px] font-bold text-slate-600 flex items-center gap-1.5 transition-colors" title="{{ $job->qualification_display }}">
                                <i class="fas fa-graduation-cap text-accent-blue"></i> {{ $job->qualification_display }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                            <div class="flex flex-col">
                                @if($job->salary_range)
                                <span class="text-xs sm:text-sm font-bold text-slate-700"><i class="fas fa-rupee-sign text-slate-400"></i> {{ $job->salary_range }}</span>
                                @endif
                                <span class="text-[10px] text-slate-400 font-medium mt-0.5">Posted {{ $job->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" 
                                        data-share-url="{{ route('jobs.show', $job->id) }}"
                                        onclick="copyJobUrl(this.dataset.shareUrl, this)" 
                                        title="Copy Job Link to Share" 
                                        class="p-2 w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all active:scale-95 cursor-pointer flex items-center justify-center shadow-2xs">
                                    <i class="fas fa-link text-[#0ea5e9]"></i>
                                </button>
                                <a href="{{ route('jobs.show', $job->id) }}" class="text-white bg-accent-blue hover:bg-blue-600 px-4 py-2 rounded-xl font-bold text-xs transition-colors shadow-sm flex items-center gap-1.5 active:scale-95">
                                    <span>Apply</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($jobs->hasPages())
                <div class="mt-10">
                    {{ $jobs->links() }}
                </div>
            @endif
        @else
            <!-- Centered Responsive Empty State Box -->
            <div class="max-w-xl mx-auto text-center py-12 sm:py-16 px-6 border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50/80 shadow-sm reveal">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl flex items-center justify-center text-accent-blue shadow-sm text-2xl sm:text-3xl mx-auto mb-4 border border-slate-100">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-2">No Active Jobs</h3>
                <p class="text-slate-500 text-xs sm:text-sm max-w-md mx-auto mb-6 leading-relaxed">
                    We currently don't have any job openings that match your exact criteria. Please try adjusting your search filters.
                </p>
                <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#031b4e] hover:bg-[#021030] text-white rounded-xl text-xs sm:text-sm font-bold shadow-md transition-all active:scale-95">
                    <i class="fas fa-redo text-xs"></i> Clear & Reset Filters
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    (function() {

        // Dynamic Subjects and Specializations Dropdowns
        const searchCategory = document.getElementById('search_category');
        const searchSubject = document.getElementById('search_subject');
        const searchSpecialization = document.getElementById('search_specialization');
        const specializationContainer = document.getElementById('specialization_container');

        if(searchCategory && searchSubject) {
            searchCategory.addEventListener('change', function() {
                const categoryId = this.value;
                
                // Clear existing options
                searchSubject.innerHTML = '<option value="">Select Subject</option>';
                if(searchSpecialization) searchSpecialization.innerHTML = '<option value="">Select Specialization</option>';
                if(specializationContainer) specializationContainer.style.display = 'none';
                
                if(categoryId) {
                    fetch(`/api/categories/${categoryId}/subjects`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(subject => {
                                const option = document.createElement('option');
                                option.value = subject.id;
                                option.textContent = subject.name;
                                searchSubject.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching subjects:', error));
                }
            });
        }

        if(searchSubject && searchSpecialization && specializationContainer) {
            searchSubject.addEventListener('change', function() {
                const subjectId = this.value;
                
                // Clear existing options
                searchSpecialization.innerHTML = '<option value="">Select Specialization</option>';
                specializationContainer.style.display = 'none';
                
                if(subjectId) {
                    fetch(`/api/subjects/${subjectId}/specializations`)
                        .then(response => response.json())
                        .then(data => {
                            if(data.length > 0) {
                                specializationContainer.style.display = 'block';
                                data.forEach(spec => {
                                    const option = document.createElement('option');
                                    option.value = spec.id;
                                    option.textContent = spec.name;
                                    searchSpecialization.appendChild(option);
                                });
                            }
                        })
                        .catch(error => console.error('Error fetching specializations:', error));
                }
            });
        }
    })();
</script>
@endsection

