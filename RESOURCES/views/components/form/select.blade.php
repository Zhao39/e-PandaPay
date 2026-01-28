@use('\Illuminate\Support\Arr', 'Arr')
@props([
    'name' => '',
    'options' => [],
    'column' => '',
    'key' => '',
])
@php
    if ($key == '') {
        $key = $column;
    } else {
        $key = $key;
    }
@endphp
<select {{ $attributes->merge(['class' => 'form-control form-select']) }}>
    @foreach ($options as $value => $label)
        @if (Arr::accessible($label))
            <option value="{{ $label[$key] }}">{{ $label[$column] }}</option>
        @else
            <option value="{{ $value }}">{{ $label }}</option>
        @endif
    @endforeach
</select>
<div>
    @isset($errors)
        @error($name)
            <small class="text-xs text-danger">{{ $message }}</small>
        @enderror
    @endisset
</div>
