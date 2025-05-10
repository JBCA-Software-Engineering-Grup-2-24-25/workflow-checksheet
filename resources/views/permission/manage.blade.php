<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Laravel') }} | Permissions | Update Permissions
    </x-slot>
    <x-breadcrumbs>
        <x-breadcrumbs.item :isActive="false" :url="route(name: 'permission.index', absolute: false)" name="Permission" />
        <x-breadcrumbs.item :isActive="false" name="Update Permission" />
    </x-breadcrumbs>
    <div class="px-8 py-5 mt-6 space-y-4 bg-white rounded-lg shadow-xl">
        <h4 class="mb-10 text-xl capitalize">Update Permission</h4>
        @include('permission.partials.form', [
            'method' => 'PUT',
            'action' => route('permission.update', ['permission' => $data->id]),
        ])
    </div>
</x-app-layout>
