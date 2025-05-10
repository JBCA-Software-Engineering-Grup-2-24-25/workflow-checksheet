@props([
    'title' => ''
])
<div {{ $attributes->merge(['class' => 'px-5 py-3 mt-6 bg-white rounded']) }}>
    @if ($title)
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold">
            {{ $title }}
        </h3>
    </div>
    @endif
    {{ $slot }}
</div>
