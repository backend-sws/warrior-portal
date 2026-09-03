<x-mail::message>
# Your Registration Plan Has Expired 🔄

Dear {{ $user->name }},

Your current registration plan with **Warriors Educare** has expired because all your allocated interview/job opportunities have been used.

### Renew Now to Continue
By renewing, you will get:
- ✅ **3 fresh job/interview opportunities**
- ✅ Access to new job vacancies
- ✅ Priority shortlisting support
- ✅ Dedicated placement assistance

Don't miss out on new opportunities! Renew your plan today and let us help you find your dream teaching job.

<x-mail::button :url="route('candidate.dashboard')">
Renew My Registration
</x-mail::button>

<x-mail::panel>
Have questions? Contact us:  
**Email:** support@warriorseducare.com | **Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
