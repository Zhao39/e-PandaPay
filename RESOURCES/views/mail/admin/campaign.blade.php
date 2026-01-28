{{-- blade-formatter-disable --}}
<x-mail::message>
# {{ $salutaion ? $salutaion : "Hello" }} {{ $recipient}},

{!! $body !!}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
