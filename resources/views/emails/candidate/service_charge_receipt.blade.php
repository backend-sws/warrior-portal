<x-mail::message>
# Payment Receipt ✅

Dear {{ $user->name }},

Thank you! Your **Service Charge payment** has been successfully received.

### Payment Details
**Amount Paid:** ₹{{ number_format($amountPaid, 2) }}  
**Invoice Number:** #{{ $invoice->invoice_no }}  
**Payment Date:** {{ now()->format('d M Y, h:i A') }}  
**Status:** ✅ Paid

@if($invoice->jobApplication?->jobPost)
**For Position:** {{ $invoice->jobApplication->jobPost->title }}  
**School:** {{ $invoice->jobApplication->jobPost->school_name }}
@endif

You can download your invoice from the Service Charge section of your dashboard.

<x-mail::button :url="route('candidate.serviceCharge.show')">
View Invoice & Payment History
</x-mail::button>

<x-mail::panel>
**Warriors Educare**  
Sardar Patel Colony, Sandalpur Rd, Kumhrar, Patna, Bihar  
**Email:** info@warriorseducare.in | **Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
