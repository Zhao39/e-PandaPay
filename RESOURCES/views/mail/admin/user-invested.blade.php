{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

{{ $plan->user->name }} just purchased an investment plan <br>

<x-mail::panel>
Name: {{ $plan->plan->name }} <br>
Amount: {{ $plan->amount }} <br>
Status: {{ $plan->status }} <br>
Date: {{ $plan->created_at }} <br>
</x-mail::panel>

Please login for more information.

<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
