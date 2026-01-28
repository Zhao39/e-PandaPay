{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

{{ $data['name'] }} just subscribe to your signal provider <br>

<x-mail::panel>
Name: {{ $data['name'] }} <br>
Duration: {{ $data['duration'] }} <br>
Date: {{ $data['created_at'] }} <br>
</x-mail::panel>

For more information, please login.
<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
