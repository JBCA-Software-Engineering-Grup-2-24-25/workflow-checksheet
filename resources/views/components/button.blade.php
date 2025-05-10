@props([
    'color' => 'primary',
    'rounded' => true,
])

@php
    $color = [
        'primary' => 'bg-indigo-500 hover:bg-indigo-600 text-white',
        'light-primary' => 'bg-indigo-50 text-indigo-500 hover:bg-indigo-500 hover:text-white',
        'secondary' => 'bg-secondary hover:bg-secondary-dark',
        'light-secondary' => 'bg-gray-100 text-gray-500 hover:bg-gray-500 hover:text-white',
        'danger' => 'bg-red-600 hover:bg-red-700',
        'light-danger' => 'bg-red-50 text-red-500 hover:bg-red-700 hover:text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600',
        'light-warning' => 'bg-yellow-50 text-yellow-500 hover:bg-yellow-600 hover:text-white',
        'success' => 'bg-green-500 hover:bg-green-600',
        'light-success' => 'bg-green-50 text-green-500 hover:bg-green-600 hover:text-white',
        'info' => 'bg-blue-500 hover:bg-blue-600',
        'light-info' => 'bg-blue-50 text-blue-500 hover:bg-blue-600 hover:text-white',
    ][$color];

@endphp
<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            $color .
            ' ' .
            ($rounded ? 'rounded-md ' : '') .
            'px-4
        py-2 text-sm hover:shadow-xl transition duration-150',
    ]) }}>
    {{ $slot }}
</button>
