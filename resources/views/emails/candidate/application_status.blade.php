<x-mail::message>
# Application Status Update

Dear {{ $application->candidate->name }},

There is an update regarding your application for the **{{ $application->jobPost->title }}** position at **{{ $application->jobPost->school_name }}**.

Your application status is now: **{{ $application->status_label }}**

@if($application->status === 'shortlisted')
Congratulations! Your profile has been shortlisted. We will notify you once your interview or demo session is scheduled.
@elseif($application->status === 'forwarded_to_school')
Your profile has been forwarded to the school / educational institution for review.
@elseif($application->status === 'demo_scheduled')
Your demo / interview session has been scheduled! Please review the date, time, and location/link below.
@elseif($application->status === 'hired')
Congratulations! You have been selected and hired for this position! Please check your dashboard for further instructions and service charge details.
@elseif($application->status === 'rejected_by_school')
The school / institute has decided to move forward with other candidates at this time. Keep your profile active for other openings!
@elseif($application->status === 'tutor_backed_out')
Your application has been marked as backed out per your update.
@elseif(in_array($application->status, ['rejected_by_admin', 'rejected']))
Unfortunately, your application could not be approved at this time.
@endif

@if($application->remarks)
**Additional Remarks:**
{{ $application->remarks }}
@endif

@if($application->interview_date)
### Interview Details
**Date & Time:** {{ \Carbon\Carbon::parse($application->interview_date)->format('M d, Y h:i A') }}
@if($application->interview_link)
**Meeting Link / Location:** {{ $application->interview_link }}
@endif
@endif

<x-mail::button :url="route('candidate.applications.index')">
View Applications
</x-mail::button>

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
