<x-mail::message>
# Home Tuition Application Update

Dear {{ $application->candidate->name }},

There is an update regarding your application for **Class {{ $application->tuitionLead?->class ?? 'N/A' }} ({{ $application->tuitionLead?->subjects ?? 'All Subjects' }})** in **{{ $application->tuitionLead?->location ?? 'Patna' }}**.

---

### Application Status: **{{ ucfirst($application->status) }}**

@if($application->status === 'Assigned')
🎉 **Congratulations!** You have been officially assigned as the tutor for this home tuition requirement.

**Parent & Tuition Details:**
- **Parent Name:** {{ $application->tuitionLead?->parent_name }}
- **Parent Contact:** {{ $application->tuitionLead?->parent_mobile }}
- **Location:** {{ $application->tuitionLead?->location }}
- **Class & Subjects:** Class {{ $application->tuitionLead?->class }} ({{ $application->tuitionLead?->subjects }})
- **Monthly Fee:** ₹{{ number_format($application->tuitionLead?->fee ?? 0) }}/month

Please contact the parent promptly to introduce yourself and coordinate the teaching schedule.

@elseif($application->status === 'Shortlisted')
⭐ **Great news!** Your profile has been shortlisted for this home tuition assignment. The administration will contact you shortly to coordinate the trial demo session.

@elseif($application->status === 'Rejected')
We regret to inform you that your application for this specific tuition requirement was not selected.

@if($application->remarks)
> **Feedback / Rejection Reason:**  
> {{ $application->remarks }}
@endif

Don't worry! Your profile remains active and eligible for many other open home tuition leads on our portal.
@endif

@if($application->demo_date)
---
### 📅 Trial Demo Session Details
- **Date & Time:** {{ \Carbon\Carbon::parse($application->demo_date)->format('l, d M Y \a\t h:i A') }}
- **Location:** {{ $application->tuitionLead?->location }}
- **Instructions:** Please be punctual, dress professionally, and carry your introductory study notes.
@endif

@if($application->status !== 'Rejected' && $application->remarks)
---
**Admin Note / Instructions:**  
_{{ $application->remarks }}_
@endif

<x-mail::button :url="route('candidate.applications.index', ['tab' => 'tuitions'])">
View Your Applications on Dashboard
</x-mail::button>

<x-mail::panel>
**Warriors Educare Support**  
Sardar Patel Colony, Sandalpur Rd, Kumhrar, Patna, Bihar  
**Phone:** +91-8210545286  
**Email:** info@warriorseducare.in
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
