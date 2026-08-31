@extends('layouts.app')

@section('content')
@include('employer.partials.nav')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#031b4e]">Post a New Job</h1>
        <p class="text-sm text-[#031b4e]/70 mt-0.5">Fill in the details to post a new job requirement. Once approved, it will be visible to candidates.</p>
    </div>

    <div class="light-metallic-blue-card bg-[#f4f7f5]/50 rounded-2xl border border-[#031b4e]/10 overflow-hidden shadow-xl reveal">
        <div class="p-8">
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                    <i class="fas fa-check-circle mt-1"></i>
                    <div>
                        <p class="font-bold text-sm">Success!</p>
                        <p class="text-xs mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-1"></i>
                    <div>
                        <p class="font-bold text-sm">Please fix the following errors:</p>
                        <ul class="list-disc pl-5 text-xs mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('employer.jobs.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Institution Details -->
                <div>
                    <h3 class="text-lg font-bold text-[#031b4e] mb-4 flex items-center gap-2 border-b border-[#031b4e]/10 pb-2"><i class="fas fa-university text-accent-yellow"></i> Institution Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Institution/School Name</label>
                            <input type="text" name="school_name" value="{{ old('school_name', $profile?->school_name ?? '') }}" class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Contact Person</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person', $profile?->contact_person ?? auth()->user()->name) }}" class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Contact Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Phone Number <span class="text-xs text-[#031b4e]/40 font-normal lowercase">(optional)</span></label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors" placeholder="e.g. 9876543210 (optional)">
                        </div>
                    </div>
                </div>

                <!-- Job Details Repeater -->
                <div class="pt-2" x-data="jobRepeater()">
                    <div class="flex justify-between items-center mb-4 border-b border-[#031b4e]/10 pb-2">
                        <h3 class="text-lg font-bold text-[#031b4e] flex items-center gap-2"><i class="fas fa-briefcase text-accent-yellow"></i> Job Requirements</h3>
                    </div>

                    <template x-for="(job, index) in jobs" :key="job.id">
                        <div class="space-y-6 mb-6 p-6 bg-[#031b4e]/5 border border-[#031b4e]/10 rounded-2xl relative shadow-sm hover:shadow-md transition-shadow">
                            <!-- Job Number & Remove Button -->
                            <div class="flex justify-between items-center border-b border-[#031b4e]/10/50 pb-3 mb-2">
                                <span class="text-sm font-bold text-accent-blue tracking-wide uppercase" x-text="`Job Requirement #${index + 1}`"></span>
                                <button type="button" x-show="jobs.length > 1" @click="jobs.splice(index, 1)" class="text-red-400 hover:text-red-600 transition-colors flex items-center gap-1 text-xs font-bold uppercase" title="Remove Job">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Job Title <span class="text-red-500">*</span></label>
                                <input type="text" :name="`jobs[${index}][title]`" required class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors" placeholder="e.g. Senior Physics Teacher">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Category -->
                                <div>
                                    <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Job Category <span class="text-red-500">*</span></label>
                                    <select :name="`jobs[${index}][category_id]`" x-model="job.category_id" @change="fetchSubjects(job)" required class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors cursor-pointer">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Subject (Dynamic based on Category) -->
                                <div>
                                    <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Subject <span class="text-red-500">*</span></label>
                                    <select :name="`jobs[${index}][subject_id]`" x-model="job.subject_id" :disabled="!job.category_id || job.loadingSubjects" required class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors disabled:opacity-50 disabled:bg-slate-100 cursor-pointer">
                                        <option value="" x-text="!job.category_id ? '— First Select Category —' : (job.loadingSubjects ? 'Loading subjects...' : 'Select Subject')"></option>
                                        <template x-for="subject in job.subjects" :key="subject.id">
                                            <option :value="subject.id" x-text="subject.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Qualification (Enabled once Subject is selected) -->
                                <div>
                                    <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Required Qualification <span class="text-red-500">*</span></label>
                                    <select :name="`jobs[${index}][qualification_id]`" x-model="job.qualification_id" :disabled="!job.subject_id" required class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors disabled:opacity-50 disabled:bg-slate-100 cursor-pointer">
                                        <option value="" x-text="!job.subject_id ? '— First Select Subject —' : 'Select Qualification'"></option>
                                        @foreach($qualifications as $qualification)
                                            <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- State -->
                                <div>
                                    <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">State <span class="text-red-500">*</span></label>
                                    <select :name="`jobs[${index}][state_id]`" x-model="job.state_id" @change="fetchCities(job)" required class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors cursor-pointer">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- City (Dynamic based on State) -->
                                <div>
                                    <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">City <span class="text-red-500">*</span></label>
                                    <select :name="`jobs[${index}][city_id]`" x-model="job.city_id" :disabled="!job.state_id || job.loadingCities" required class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors disabled:opacity-50 disabled:bg-slate-100 cursor-pointer">
                                        <option value="" x-text="!job.state_id ? '— First Select State —' : (job.loadingCities ? 'Loading cities...' : 'Select City')"></option>
                                        <template x-for="city in job.cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Salary Range (Monthly)</label>
                                    <input type="text" :name="`jobs[${index}][salary_range]`" class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors" placeholder="e.g. 40,000 - 60,000">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Job Description <span class="text-red-500">*</span></label>
                                <textarea :name="`jobs[${index}][description]`" required rows="4" class="w-full bg-white border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:border-accent-yellow transition-colors resize-none" placeholder="Describe the responsibilities and requirements..."></textarea>
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addJob()" class="w-full mt-2 px-6 py-4 bg-[#031b4e]/10 text-[#031b4e] font-bold rounded-2xl border-2 border-dashed border-[#031b4e]/10 hover:border-accent-yellow hover:text-accent-yellow hover:bg-accent-yellow/5 transition-all flex items-center justify-center gap-2 group">
                        <i class="fas fa-plus-circle text-xl group-hover:scale-110 transition-transform"></i> Add Another Job Requirement
                    </button>
                </div>

                <div class="pt-6 border-t border-[#031b4e]/10 text-right">
                    <a href="{{ route('employer.jobs.index') }}" class="inline-block px-6 py-3.5 bg-white hover:bg-white/5 text-[#031b4e] rounded-xl font-bold transition-colors mr-2">Cancel</a>
                    <button type="submit" class="px-8 py-3.5 bg-accent-yellow text-[#031b4e] font-bold rounded-xl shadow-lg hover:shadow-md hover:-translate-y-1 hover:shadow-lg transition-all duration-300 transition-all">Submit for Approval</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function jobRepeater() {
        return {
            jobs: [
                {
                    id: Date.now(),
                    category_id: '',
                    subject_id: '',
                    qualification_id: '',
                    state_id: '',
                    city_id: '',
                    subjects: [],
                    cities: [],
                    loadingSubjects: false,
                    loadingCities: false
                }
            ],
            
            addJob() {
                this.jobs.push({
                    id: Date.now(),
                    category_id: '',
                    subject_id: '',
                    qualification_id: '',
                    state_id: '',
                    city_id: '',
                    subjects: [],
                    cities: [],
                    loadingSubjects: false,
                    loadingCities: false
                });
            },
            
            fetchSubjects(job) {
                job.subject_id = '';
                job.qualification_id = '';
                if(job.category_id) {
                    job.loadingSubjects = true;
                    fetch(`/api/categories/${job.category_id}/subjects`)
                        .then(response => response.json())
                        .then(data => {
                            job.subjects = data;
                        })
                        .catch(error => {
                            console.error('Error fetching subjects:', error);
                            job.subjects = [];
                        })
                        .finally(() => {
                            job.loadingSubjects = false;
                        });
                } else {
                    job.subjects = [];
                }
            },
            
            fetchCities(job) {
                job.city_id = '';
                if(job.state_id) {
                    job.loadingCities = true;
                    fetch(`/api/states/${job.state_id}/cities`)
                        .then(response => response.json())
                        .then(data => {
                            job.cities = data;
                        })
                        .catch(error => {
                            console.error('Error fetching cities:', error);
                            job.cities = [];
                        })
                        .finally(() => {
                            job.loadingCities = false;
                        });
                } else {
                    job.cities = [];
                }
            }
        }
    }
</script>
@endpush
