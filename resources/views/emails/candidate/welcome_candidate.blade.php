<x-mail::message>
# Welcome to Warriors Educare! 🎉

Dear {{ $user->name }},

Your profile has been successfully created on the **Warriors Educare** portal. Our team has registered you on the platform.
Your account has been successfully created by our administration team. You can now log in to your dashboard to complete your profile, view job matches, and apply for positions.

<x-mail::panel>
**Your Login Credentials:**  
**Email:** {{ $user->email }}  
**Password:** {{ $password }}
</x-mail::panel>

<x-mail::button :url="route('login')">
Login to Dashboard
</x-mail::button>

<x-mail::panel>
If you have any questions, please contact us:  
**Email:** support@warriorseducare.com  
**Phone:** +91-8210545286
</x-mail::panel>

Best regards,<br>
**Warriors Educare Team**
</x-mail::message>
