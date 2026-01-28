{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin

{{ $data['name'] }} just purchase a membership course.<br>

<x-mail::panel>
Customer Name: {{ $data['name'] }} <br>
Course Name: {{ $data['course_name'] }} <br>
</x-mail::panel>

For more information, please login.
<x-mail::button :url="route('admin.dashboard')">
Login now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- blade-formatter-disable --}}
