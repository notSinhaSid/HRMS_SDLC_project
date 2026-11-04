<x-mail::message>
# Welcome

Hello {{ $name }},

Your HRMS account has been created.

**Login email:** {{ $email }}  
**Temporary password:** {{ $tmpPassword }}

You will be asked to change this password on your first login.

<x-mail::button :url="route('login')">
Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
