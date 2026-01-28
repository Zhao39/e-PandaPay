{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

This to notify you that {{ $account->user->name }} submited their trading account details for trading, please login to take neccessary action

<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
