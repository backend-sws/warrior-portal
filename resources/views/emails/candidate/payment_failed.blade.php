<x-mail::message>
# Payment Failed ❌

Dear {{ $user->name }},

Unfortunately, your payment could **not be processed** successfully. Please try again.

### Transaction Details
**Transaction ID:** {{ $transactionId }}  
**Amount:** ₹{{ number_format((float)$amount, 2) }}  
**Status:** Failed / Cancelled

No amount has been deducted from your account. Please retry the payment from your dashboard.

<x-mail::button :url="route('candidate.dashboard')">
Retry Payment
</x-mail::button>

<x-mail::panel>
If the amount was deducted but registration wasn't completed, please contact us immediately:  
**Email:** support@warriorseducare.com  
**Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
