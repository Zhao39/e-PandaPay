{{-- blade-formatter-disable --}}
<x-mail::message>
# Dear {{ $name }},

To complete the authentication process, please use the following two-factor code:
<x-mail::panel>
<h3 style="font-size: 100px: font-weight: bold">{{ $code }}</h3>
</x-mail::panel>

Please enter this code within {{ $expiry }} time to verify your identity. If you did not initiate this request, please ignore this email. Also endeavour to change your password as soon as possible.
<br>
Best regards, <br>
{{ config('app.name') }}

</x-mail::message>
{{-- blade-formatter-disable --}}
