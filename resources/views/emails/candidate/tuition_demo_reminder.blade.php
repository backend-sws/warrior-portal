<x-mail::message>
# 🎓 Home Tuition Demo Class Reminder

Dear **{{ $application->candidate->name ?? 'Tutor' }}**,

This is a reminder from **Warriors Educare** regarding your upcoming trial demo session with the student/parent.

<x-mail::panel>
### 📅 Demo Class Details
- **Student Grade / Class:** {{ $application->tuitionLead->class ?? 'N/A' }}
- **Subject(s):** {{ $application->tuitionLead->subject ?? 'N/A' }}
- **Demo Scheduled Date & Time:** **{{ \Carbon\Carbon::parse($application->demo_date)->format('d M Y, h:i A') }}**
- **Location / Area:** {{ $application->tuitionLead->location ?? 'N/A' }}
@if($application->tuitionLead->parent_phone)
- **Parent Contact:** {{ $application->tuitionLead->parent_phone }}
@endif
</x-mail::panel>

### 📌 Guidelines for a Successful Demo:
1. Arrive or connect 10 minutes before the scheduled time.
2. Carry your updated resume, photo ID, and relevant study notes/lesson plan.
3. Be professional, engaging, and patient with the student.
4. After completing the session, update your trial feedback in your portal.

<x-mail::button :url="route('candidate.tuitions.index')">
View Tuition Dashboard
</x-mail::button>

Best regards,  
**Warriors Educare Team**  
Support: support@warriorseducare.com | +91 8210545286
</x-mail::message>
