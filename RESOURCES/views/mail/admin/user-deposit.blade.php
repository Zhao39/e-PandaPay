{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

@if ($deposit->status == 'Processed')
Deposit from  {{ $deposit->user->name }} is processed. <br>
Deposit amount: {{ $settings->currency }}{{ $deposit->amount }} <br>
Date: {{ $deposit->created_at }}, <br>
Status: {{ $deposit->status }}.
@endif

@if ($deposit->status == 'Pending')
{{ $deposit->user->name }} just made a deposit and it's pending, please login to process this deposit. <br>
Deposit amount: {{ $settings->currency }}{{ $deposit->amount }} <br>
Date: {{ $deposit->created_at }}, <br>
Status: {{ $deposit->status }}.
@endif

Please login for more information. <br>

<x-mail::button :url="route('admin.dashboard')">
Login Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
