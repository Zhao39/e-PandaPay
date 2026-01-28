{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello {{ $name }},

This is a password reset request from your account. Use the token below to reset your password. please ignore if you did not make this request.

<x-mail::panel>
<h3 style="font-size: 25px">{{ $token }}</h3>
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
