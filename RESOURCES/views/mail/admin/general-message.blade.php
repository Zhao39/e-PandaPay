{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello {{ $recipient_name }}

{{ $message }}
<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
