@props(['label', 'model' => 'permissions'])
<label class="form-check-label">
    <input value="{{ $label }}" type="checkbox" {{ $attributes->merge(['class' => 'form-check-input']) }}
        wire:model='{{ $model }}'>
    <span class="form-check-sign">{{ $label }}</span>
</label>
