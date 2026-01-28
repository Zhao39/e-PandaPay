{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

<br>
@if ($withdrawal->status == 'processed')
Withdrawal from  {{ $withdrawal->user->name }} is processed. <br>
Withdrawal amount: {{ $settings->currency }}{{ $withdrawal->amount }} <br>
Date: {{ $withdrawal->created_at }}, <br>
Payment Mode: {{ $withdrawal->payment_mode }}, <br>
Status: {{ $withdrawal->status }}.
@endif

@if ($withdrawal->status == 'pending')
{{ $withdrawal->user->name }} just placed a withdrawal request and it's pending, please login to process this withdrawal. <br>
Withdrawal amount: {{ $settings->currency }}{{ $withdrawal->amount }} <br>
Date: {{ $withdrawal->created_at }}, <br>
Payment Mode: {{ $withdrawal->payment_mode }},<br>
Status: {{ $withdrawal->status }}.
@endif

Please login for more information. <br>

<x-mail::button :url="route('admin.dashboard')">
Login Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
