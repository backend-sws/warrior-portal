<x-mail::message>
# Interview Scheduled! 🎯

Dear {{ $application->candidate->name }},

Great news! An **interview has been scheduled** for your job application. Please review the details below and be prepared.

### Interview Details
**Position:** {{ $application->jobPost->title ?? 'N/A' }}  
**School/Institution:** {{ $application->jobPost->school_name ?? 'N/A' }}  
**Interview Date:** {{ $application->interview_date ? \Carbon\Carbon::parse($application->interview_date)->format('d M Y, h:i A') : 'To be confirmed' }}  
@if($application->interview_link)
**Interview Link / Venue:** {{ $application->interview_link }}
@endif

### Preparation Tips
- Review the job description carefully
- Prepare your subject knowledge and demo lesson
- Keep your documents ready (Resume, Certificates)
- Be punctual and professional

<x-mail::button :url="route('candidate.applications.index')">
View My Applications
</x-mail::button>

<x-mail::panel>
If you have any questions about the interview, please contact us:  
**Email:** support@warriorseducare.com | **Phone:** +91-8210545286
</x-mail::panel>

Best of luck! 🍀<br>
**Warriors Educare Team**
</x-mail::message>
