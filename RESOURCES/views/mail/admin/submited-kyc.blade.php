{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

{{ $kyc->user->name }} just submited their KYC application. <br>
Plase login to view application and take appropriate action.

<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
