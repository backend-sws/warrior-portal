<x-mail::message>
# Job Post Status Update

Dear {{ $job->contact_person ?? 'School/Institution' }},

Thank you for submitting your job post to **Warriors Educare**. After reviewing your submission, we regret to inform you that your job post could not be approved at this time.

### Job Post Details
**Position:** {{ $job->title }}  
**School/Institution:** {{ $job->school_name ?? 'N/A' }}  
**Submitted:** {{ $job->created_at ? $job->created_at->format('d M Y') : 'N/A' }}  
**Status:** ❌ Not Approved

@if($reason)
### Reason
{{ $reason }}
@else
Our team reviews each post to ensure quality and relevance for our candidate pool. Unfortunately, this post did not meet our current requirements.
@endif

### What You Can Do
- Review and update your job posting details
- Ensure all required fields are filled correctly
- Contact us if you need clarification or wish to resubmit

<x-mail::button :url="'mailto:info@warriorseducare.in'">
Contact Us to Resubmit
</x-mail::button>

<x-mail::panel>
We value your partnership and hope to assist you with your recruitment needs.  
**Email:** info@warriorseducare.in | **Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
