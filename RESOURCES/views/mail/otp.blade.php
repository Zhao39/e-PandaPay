{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello {{ $name }}

You have initiated a withdrawal request, use the OTP below to complete your withdrawal.
<h1 style="font-weight: bolder; font-size:50px; text-align: center; background-color: #f0f0f0; padding: 10px">
{{ $otp }}
</h1>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
