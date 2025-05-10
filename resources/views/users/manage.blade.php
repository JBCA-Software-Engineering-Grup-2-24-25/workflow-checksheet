<x-app-layout>
    <x-breadcrumbs>
        <x-breadcrumbs.item :url="route(name: 'users.index', absolute: false)" name="Users" />
        <x-breadcrumbs.item :isActive="true" :name="isset($user) ? __('Update User') : __('Add User')" />
    </x-breadcrumbs>
    <div class="h-full">
        <div class="px-8 py-5 space-y-4 bg-white rounded-lg shadow-xl">
            <h4 class="mb-10 text-xl capitalize">{{ isset($user) ? __('Update User') : __('Add User') }}</h4>
            @include('users.partials.form', [
                'method' => isset($user) ? 'PUT' : 'POST',
                'action' => isset($user)
                    ? route(name: 'users.update', parameters: ['user' => $user->id], absolute: false)
                    : route(name: 'users.store', absolute: false),
                'isSuperAdmin' => Auth::user()->isSuperAdmin()
            ])
        </div>
    </div>
</x-app-layout>
