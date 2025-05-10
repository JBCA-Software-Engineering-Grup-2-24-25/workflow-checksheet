@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'disabled' => false,
])

@php
    $id = $id !== null ? $id : $name . '-' . Str::random(8); // Generate a unique ID
@endphp

<div class="flex items-center mt-2">
    <input type="checkbox" id="{{ $id }}" name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'mr-2 border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300',
        ]) }}
        {{ $disabled ? 'disabled' : '' }}>
    @if ($label)
        <label for="{{ $id }}"
            class="text-base {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">{{ $label }}</label>
    @endif
</div>
