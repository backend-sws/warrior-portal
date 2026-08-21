<x-mail::message>
# Important: Registration Limit Warning

Dear {{ $user->name }},

We noticed you have been actively applying for jobs on Warriors Educare! 

This is a quick notification to let you know that you have only **{{ $remaining }}** opportunity(s) remaining on your current registration plan.

Once you exhaust all your allowed applications, you will need to renew your plan to continue applying for new jobs.

<x-mail::button :url="route('candidate.dashboard')">
View Your Dashboard
</x-mail::button>

We wish you the best of luck with your current applications! If you have any questions about renewing your plan, please contact us.

<x-mail::panel>
**Get In Touch**  
Career Point Building, 2nd floor,  
Patna, 800001, Bihar

**Email:** info@warriorseducare.in  
**Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare**
</x-mail::message>
