@props(['href', 'label'])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-primary ']) }}>{{ $label }}</a>
