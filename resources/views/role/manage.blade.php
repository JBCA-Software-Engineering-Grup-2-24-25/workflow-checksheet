<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Laravel') }} | Project | {{ isset($data) ? __('Update Role') : __('Add Role') }}
    </x-slot>
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <ol class="flex gap-3 text-sm">
                <li class="text-gray-500 breadcrumb-item"> <a href="javascript:void(0)">Home</a> </li>
                <li class="text-gray-500 breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                @if (isset($data))
                    <li class="text-indigo-500 breadcrumb-item active" aria-current="page">{{ $data->name }}</li>
                @else
                    <li class="text-indigo-500 breadcrumb-item active" aria-current="page">Add Roles</li>
                @endif
            </ol>
        </div>
    </div>
    <div class="px-8 py-5 mt-6 space-y-4 bg-white rounded-lg shadow-xl">
        <h4 class="mb-10 text-xl capitalize">{{ isset($data) ? __('Update') : __('Add') }} Role</h4>
        @include('role.partials.form', [
            'method' => isset($data) ? 'PUT' : 'POST',
            'action' => isset($data)
                ? route(name: 'roles.update', parameters: $data['id'], absolute: false)
                : route(name: 'roles.store', absolute: false),
        ])
    </div>
</x-app-layout>
