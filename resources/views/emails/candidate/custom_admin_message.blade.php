<x-mail::message>
# {{ $msgTitle }}

Dear {{ $candidate->name }},

{{ $msgBody }}

<x-mail::button :url="route('candidate.dashboard')">
Go to Dashboard
</x-mail::button>

<x-mail::panel>
This message was sent by the Warriors Educare team.  
**Email:** info@warriorseducare.in | **Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
