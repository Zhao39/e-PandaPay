{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin
<strong>Name:</strong> {{ $name }}, <br>
<strong>Email:</strong> {{ $email }}, <br>

{{ $message }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
