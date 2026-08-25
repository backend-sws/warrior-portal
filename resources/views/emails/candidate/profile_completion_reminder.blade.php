<x-mail::message>
# 📝 Complete Your Teaching Profile

Dear **{{ $candidate->name ?? 'Candidate' }}**,

We noticed that your educator profile on **Warriors Educare** is currently incomplete. Complete profiles receive up to **5x more interview invitations** from top schools and premium home tuition leads.

@if(!empty($missingFields))
<x-mail::panel>
### ⚠️ Pending Information Required:
@foreach($missingFields as $field)
- **{{ $field }}**
@endforeach
</x-mail::panel>
@endif

### Why complete your profile today?
- Direct verification badge for faster school shortlisting.
- Priority matching for lucrative home tuition opportunities in your city.
- Access to digital candidate agreements and placement offers.

<x-mail::button :url="route('candidate.profile.edit')">
Complete My Profile Now
</x-mail::button>

If you need any assistance updating your profile, feel free to reply directly to this email or reach our support desk.

Warm regards,  
**Warriors Educare Team**  
Website: www.warriorseducare.com | Phone: +91 8210545286
</x-mail::message>
