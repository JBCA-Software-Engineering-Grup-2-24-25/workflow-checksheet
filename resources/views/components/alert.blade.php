@props([
    'show' => false,
    'type' => 'success',
    'setTimeout' => true
])

@php
    $type = [
        'primary' => 'bg-indigo-500 text-white',
        'secondary' => 'bg-gray-500 text-white',
        'info' => 'bg-blue-500 text-white',
        'danger' => 'bg-red-600 text-white',
        'success' => 'bg-green-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
    ][$type];
@endphp

<teleport to='body'>
    <div x-data="{ show: @js($show) }" x-show="show" x-init="{{$setTimeout ? 'setTimeout(() => show = false, 3000)' : ''}}" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-10"
        x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-10"
        class="fixed right-5 top-20 z-50 flex items-center p-4 mb-4 text-sm rounded-lg {{ $type }}"
        role="alert">
        <div>
            {{ $slot }}
        </div>
    </div>
</teleport>
