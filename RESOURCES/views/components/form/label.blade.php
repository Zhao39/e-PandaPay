@props(['label'])
<label {{ $attributes }} class="mb-2 d-block">
    {{ $label ?? $slot }}
</label>
