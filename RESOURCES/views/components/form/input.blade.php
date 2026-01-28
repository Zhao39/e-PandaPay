@props([
    'name' => '',
    'type' => 'text',
    'readOnly' => false,
    'required' => false,
    'eerors' => [],
])
<input name="{{ $name }}" type="{{ $type }}" {{ $attributes->merge(['class' => 'form-control']) }}
    @readonly($readOnly) @required($required)>
<div>
    @error($name)
        <small class="text-xs text-danger fs-6">{{ $message }}</small>
    @enderror
</div>
