@extends('layouts.app')
@section('content')

<!-- Split Hero & Form Section -->
<div class="relative w-full bg-slate-50 min-h-screen pb-20">
    <div class="absolute inset-x-0 top-0 h-[600px] md:h-[700px] bg-gradient-to-b from-[#70a1ff] to-[#d6e5ff] z-0"></div>
    
    <div class="max-w-[1400px] mx-auto px-0 md:px-6 relative z-10 pt-16 md:pt-24 flex flex-col md:flex-row gap-0 md:gap-8">
        
        <!-- Left Side: Text and Image -->
        <div class="w-full md:w-1/2 flex flex-col justify-between px-8 md:px-0 mb-12 md:mb-0">
            <div class="mb-12 md:mb-20">
                <h1 class="text-white text-5xl md:text-6xl font-light mb-4">Get in touch</h1>
                <p class="text-white/90 text-sm md:text-base font-medium">We'd love to hear from you!</p>
            </div>
            
            <div class="rounded-tr-[40px] md:rounded-tr-none md:rounded-tl-[40px] md:rounded-bl-[40px] overflow-hidden shadow-2xl h-[400px] md:h-[500px]">
                <!-- Using a modern building image as seen in the template -->
                <img src="https://images.unsplash.com/photo-1600607686527-6fb886090705?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Modern Building" class="w-full h-full object-cover" />
            </div>
        </div>

        <!-- Right Side: Contact Form Card -->
        <div class="w-full md:w-1/2 flex items-center justify-center px-4 md:px-0 md:pt-10">
            <div class="w-full max-w-xl bg-white rounded-[32px] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.1)] relative md:-ml-12 md:mt-10 z-20">
                <h2 class="text-[#040e2d] text-2xl md:text-3xl font-medium mb-2">Contact us</h2>
                <p class="text-slate-400 text-sm mb-10">We'd love to hear from you!</p>
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" id="contactForm">
                    @csrf
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Name</label>
                        <input type="text" name="name" required class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" placeholder="Your fullname">
                    </div>
                    
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Your email</label>
                        <input type="email" name="email" class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" placeholder="Your email address">
                    </div>

                    <!-- Phone (keeping from original context) -->
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Your phone</label>
                        <input type="text" name="phone" required class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" placeholder="Your phone number">
                    </div>
                    
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Your messages</label>
                        <textarea name="message" required rows="5" class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all resize-none" placeholder="Your messages here..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-[#111] text-white font-medium py-4 rounded-xl hover:bg-black hover:shadow-xl transition-all duration-300">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Contact Info Cards (Original Content Integrated) -->
<div class="py-16 px-6 lg:px-[5%] bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Location -->
            <div class="bg-white border border-slate-100 p-8 rounded-2xl flex flex-col items-center text-center gap-4 hover:border-slate-300 hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-slate-100 text-[#111] rounded-full flex items-center justify-center text-xl shrink-0 group-hover:scale-110 group-hover:bg-[#111] group-hover:text-white transition-all">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h4 class="text-slate-800 font-bold mb-2">Our Location</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Career Point Building, 2nd floor,<br>Patna,800001, Bihar</p>
                </div>
            </div>

            <!-- Email -->
            <a href="mailto:info@warriorseducare.in" class="bg-white border border-slate-100 p-8 rounded-2xl flex flex-col items-center text-center gap-4 hover:border-slate-300 hover:shadow-xl transition-all duration-300 group block">
                <div class="w-14 h-14 bg-slate-100 text-[#111] rounded-full flex items-center justify-center text-xl shrink-0 group-hover:scale-110 group-hover:bg-[#111] group-hover:text-white transition-all">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h4 class="text-slate-800 font-bold mb-2">Email Us</h4>
                    <span class="text-sm text-slate-500">info@warriorseducare.in</span>
                </div>
            </a>

            <!-- Call -->
            <a href="tel:+917070938975" class="bg-white border border-slate-100 p-8 rounded-2xl flex flex-col items-center text-center gap-4 hover:border-slate-300 hover:shadow-xl transition-all duration-300 group block">
                <div class="w-14 h-14 bg-slate-100 text-[#111] rounded-full flex items-center justify-center text-xl shrink-0 group-hover:scale-110 group-hover:bg-[#111] group-hover:text-white transition-all">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <h4 class="text-slate-800 font-bold mb-2">Call Us</h4>
                    <span class="text-sm text-slate-500">+91-7070938975</span>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- FAQ Section (From Template) -->
<div class="py-24 px-6 lg:px-[5%] bg-white border-t border-slate-100">
    <div class="max-w-3xl mx-auto text-center mb-16">
        <h4 class="text-slate-500 text-xs font-bold mb-3 uppercase tracking-[0.2em]">FAQS</h4>
        <h2 class="text-3xl md:text-4xl font-light text-[#111] mb-4">Frequently asked questions</h2>
        <p class="text-slate-500 text-sm">Explore our latest insights and recruitment advice.</p>
    </div>
    
    <div class="max-w-3xl mx-auto space-y-4" x-data="{ activeAccordion: 1 }">
        
        <!-- FAQ 1 -->
        <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
            <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full flex items-center justify-between p-6 bg-white hover:bg-slate-50 transition-colors">
                <span class="font-medium text-slate-800 text-left">How quickly can you fill an urgent vacancy?</span>
                <div class="w-10 h-10 rounded-xl bg-[#111] text-white flex items-center justify-center shrink-0 transition-transform duration-300">
                    <i class="fas" :class="activeAccordion === 1 ? 'fa-minus' : 'fa-plus'"></i>
                </div>
            </button>
            <div x-show="activeAccordion === 1" x-collapse>
                <div class="p-6 pt-0 text-slate-500 text-sm leading-relaxed border-t border-slate-100 mt-2 pt-4">
                    Thanks to our vast pre-screened database, we can typically provide a shortlist of highly qualified candidates within 48 to 72 hours of your request. Stay tuned for updates!
                </div>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
            <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full flex items-center justify-between p-6 bg-white hover:bg-slate-50 transition-colors">
                <span class="font-medium text-slate-800 text-left">Do you only recruit for teaching positions?</span>
                <div class="w-10 h-10 rounded-xl bg-[#111] text-white flex items-center justify-center shrink-0 transition-transform duration-300">
                    <i class="fas" :class="activeAccordion === 2 ? 'fa-minus' : 'fa-plus'"></i>
                </div>
            </button>
            <div x-show="activeAccordion === 2" x-collapse>
                <div class="p-6 pt-0 text-slate-500 text-sm leading-relaxed border-t border-slate-100 mt-2 pt-4">
                    No, while teachers form a large part of our network, we also recruit for administrative roles, principals, coordinators, and specialized staff like counselors and IT administrators.
                </div>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
            <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full flex items-center justify-between p-6 bg-white hover:bg-slate-50 transition-colors">
                <span class="font-medium text-slate-800 text-left">What kind of digital support do you offer?</span>
                <div class="w-10 h-10 rounded-xl bg-[#111] text-white flex items-center justify-center shrink-0 transition-transform duration-300">
                    <i class="fas" :class="activeAccordion === 3 ? 'fa-minus' : 'fa-plus'"></i>
                </div>
            </button>
            <div x-show="activeAccordion === 3" x-collapse>
                <div class="p-6 pt-0 text-slate-500 text-sm leading-relaxed border-t border-slate-100 mt-2 pt-4">
                    We provide complete end-to-end digital infrastructure setup. This includes interactive smart boards, reliable campus Wi-Fi, School Management ERP systems, and comprehensive staff training.
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
    btn.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                confirmButtonColor: '#111'
            });
            this.reset();
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#111'
        });
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
});
</script>
@endpush
