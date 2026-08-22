<x-mail::message>
# Action Required: Please Sign Your Agreement ✍️

Dear {{ $candidate->name }},

Our team has requested that you review and sign your **Registration Agreement** on the Warriors Educare portal.

Please log in to your dashboard and complete the digital signature process at the earliest.

<x-mail::button :url="route('candidate.dashboard')">
Sign Agreement Now
</x-mail::button>

<x-mail::panel>
**Why is this required?**  
Your signed agreement is a legal document that confirms your enrollment with Warriors Educare and outlines the terms of our recruitment service.
</x-mail::panel>

If you have any questions, please contact us:  
**Email:** info@warriorseducare.in | **Phone:** +91-8210545286

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
