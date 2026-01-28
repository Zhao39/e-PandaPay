{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

Your password has been successfully changed. This change was initiated on {{ now() }}.
<br>
If you did not make this change or if you have any concerns about the security of your account, please contact our support team immediately. We take the security of our systems seriously and will investigate any unauthorized access promptly. <br>

Thank you for your attention to this matter.

<x-mail::button :url="$url">
Login Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
