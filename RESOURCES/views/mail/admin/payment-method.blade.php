{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

{{ $name }} just {{ $new ? 'added' : 'updated' }} a payment method. <br>
<x-mail::panel>
Name: {{ $method->name }} <br>
Status: {{ $method->status }} <br>
@if ($new)
Date Added: {{ $method->created_at }} <br>
@else
Date Updated: {{ $method->updated_at }} <br>
@endif
By: {{ $name }}
</x-mail::panel>
Please login to review your payment method settings and to see more information.
<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
