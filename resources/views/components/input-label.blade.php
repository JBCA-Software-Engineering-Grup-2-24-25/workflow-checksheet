@props([
    'value' => '',
    'tooltips' => false,
    'tooltipsContent' => '',
    'required' => false
])

<div class="flex items-center">
    <label {{ $attributes }}>
        {{ $value ?? $slot }}
    </label>

    @if ($required)
        <span class="text-red-400">*</span>
    @endif

    @if ($tooltips)
        <div class="ms-1">
            @if (isset($tooltipSlot))   <!-- used for x-bind content data -->
                {{ $tooltipSlot }}
            @else
                <x-tippy :data-tippy-content="$tooltipsContent" />
            @endif
        </div>
    @endif
</div>
