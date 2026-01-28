{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

{{ $plan->user->name }}'s invesment plan just exipired. <br> <br>

<strong>Plan Details:</strong> <br>
<strong>Plan Name:</strong> {{ $plan->plan->name }} <br>
<strong>Plan Amount:</strong> {{ $settings->currency }}{{ $plan->amount }} <br>
<strong>Expired At:</strong> {{ $plan->expire_date }} <br>
<strong>ROI:</strong> {{ $settings->currency }}{{ $plan->profit_earned }} <br>

Please login for more information.
<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
