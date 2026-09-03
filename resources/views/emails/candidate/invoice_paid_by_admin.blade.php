<x-mail::message>
# Invoice Marked as Paid ✅

Dear {{ $candidate->name }},

This is to inform you that your **Service Charge invoice** has been marked as **Paid** by the Warriors Educare team.

### Invoice Details
**Invoice Number:** #{{ $invoice->invoice_no }}  
**Amount:** ₹{{ number_format($invoice->amount, 2) }}  
**Status:** ✅ Paid  
**Updated Date:** {{ now()->format('d M Y') }}

@if($invoice->jobApplication?->jobPost)
**Position:** {{ $invoice->jobApplication->jobPost->title }}  
**School:** {{ $invoice->jobApplication->jobPost->school_name }}
@endif

You can view your complete payment history from your dashboard.

<x-mail::button :url="route('candidate.serviceCharge.show')">
View Payment History
</x-mail::button>

<x-mail::panel>
**Warriors Educare**  
**Email:** support@warriorseducare.com | **Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
