@props([
    'options' => [],
    'placeholder' => null,
    'disabledPlaceholder' => true,
    'defaultValue' => null,
    'emptyValue' => '',
])

<select
    {{ $attributes->merge([
        'class' => 'py-3 text-base border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300',
    ]) }}>

    @if ($placeholder)
        <option value="" {{ $disabledPlaceholder ? 'disabled' : '' }} {{ $defaultValue === null ? 'selected' : null }}>{{ $placeholder }}</option>
    @endif

    @if ($emptyValue)
        <option value="" {{ $defaultValue === null ? 'selected' : null }}>{{ $emptyValue }}</option>
    @endif

    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $defaultValue !== null && $value == $defaultValue ? 'selected' : null }}>
            {{ $label }}</option>
    @endforeach
</select>
