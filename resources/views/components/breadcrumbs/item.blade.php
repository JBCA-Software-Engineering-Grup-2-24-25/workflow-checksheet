@props(['name', 'url' => '', 'isActive' => false])

@if ($isActive)
    <li class="text-indigo-500 breadcrumb-item active" aria-current="page">
        {{ $name }}
    </li>
@else
    <li class="text-gray-500 breadcrumb-item">
        <a href="{{ $url }}">{{ $name }}</a>
    </li>
@endif
