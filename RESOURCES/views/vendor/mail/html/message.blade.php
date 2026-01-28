{{-- blade-formatter-disable --}}
<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{-- <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ config('app.name') }}" width="{{ $settings->website_logo_size }}"> --}}
<img src="{{ url('/storage/'.$settings->logo) }}" alt="{{ config('app.name') }}" width="{{ $settings->website_logo_size }}">
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
{{-- blade-formatter-disable --}}
