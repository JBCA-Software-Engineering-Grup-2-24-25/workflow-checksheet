@props(['messages' => [], 'type' => ''])

@if (!empty($messages))
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach (((array) $messages) as $message)
            @if (is_array($message))
                @foreach ($message as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                <li>{{ $message }}</li>
            @endif
        @endforeach
    </ul>
@elseif(!empty($type))
    <template x-if="form.invalid(@js($type))">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
            <li x-text="form.errors.{{ $type }}"></li>
        </ul>
    </template>
@endif
