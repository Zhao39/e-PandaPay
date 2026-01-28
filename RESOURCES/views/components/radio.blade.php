@props(['name' => '', 'label'])
<input type="radio" name="{{ $name }}" class="selectgroup-input" {{ $attributes }}>
<span class="selectgroup-button">{{ $label }}</span>
