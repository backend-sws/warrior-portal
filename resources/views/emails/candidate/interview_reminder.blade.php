<x-mail::message>
# Interview Reminder

Dear {{ $application->candidate->name }},

This is a quick reminder that your interview for the **{{ $application->jobPost->title }}** position at **{{ $application->jobPost->school_name }}** is scheduled for tomorrow!

### Interview Details
**Date & Time:** {{ \Carbon\Carbon::parse($application->interview_date)->format('l, F j, Y \a\t g:i A') }}  

@if($application->interview_link)
**Meeting Link / Location:** [Click here to join]({{ $application->interview_link }})  
*(Or copy and paste this link: {{ $application->interview_link }})*
@endif

@if($application->remarks)
**Special Instructions:**  
{{ $application->remarks }}
@endif

Please ensure you are prepared and arrive (or log in) at least 5 minutes early.

<x-mail::button :url="route('candidate.applications.index')">
View Application Details
</x-mail::button>

Best of luck!

<x-mail::panel>
**Get In Touch**  
Career Point Building, 2nd floor,  
Patna, 800001, Bihar

**Email:** support@warriorseducare.com  
**Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare**
</x-mail::message>
