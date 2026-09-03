<x-mail::message>
# New Service Charge Invoice

Dear {{ $invoice->candidate->name ?? 'Candidate' }},

Congratulations again on your placement! 

An invoice for your service charge has been generated. Please review the details below and ensure payment is made before the due date to avoid any late fees.

### Invoice Details
**Invoice Number:** #{{ $invoice->invoice_no }}  
**Amount Due:** ₹{{ number_format($invoice->amount, 2) }}  
**Due Date:** {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}  
**Status:** {{ ucfirst($invoice->status) }}  

<x-mail::button :url="route('candidate.serviceCharge.show')">
Pay Invoice Now
</x-mail::button>

If you have already made this payment offline, please contact us so we can update our records.

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
