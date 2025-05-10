<form class="space-y-3" enctype="multipart/form-data" x-data="{
    form: $form(@js($method), '{{ $action }}', {
        name: '{{ old('name', isset($user->name) ? $user->name : '') }}',
    })
}">
    @csrf
    @method($method)

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <!-- start::Name Input -->
        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="name" :value="__('Name')" required />
            </div>
            <x-text-input id="name" name="name" type="text" class="block w-full mt-1" x-model="form.name"
                required autofocus autocomplete="name" @change="form.validate('name')" />
            <x-input-error class="mt-2" type="name" />
        </div>
        <!-- end::Name Input -->

        <!-- start::Email Input -->
        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="email" :value="__('Email')" required />
            </div>
            <x-text-input name="email" type="email" class="block w-full mt-1" :value="old('email', isset($user->email) ? $user->email : '')" :disabled="isset($user->email) && !$isSuperAdmin ? true : false"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->manageUserForm->get('email')" />
        </div>
        <!-- end::Email Input -->

        <!-- start::Role Select -->
        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="role_id" :value="__('Role')" required />
            </div>
            <x-form.choices placeholder="Select Role" name="role_id" :defaultValue="$role" :initialData="$roles"
                searchUrl="{{ route(name: 'api.roles.search', parameters: [], absolute: false) }}" />
            <x-input-error class="mt-2" :messages="$errors->manageUserForm->get('role_user_id')" />
        </div>
        <!-- end::Role Select -->

        <!-- start::Password Input -->
        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="password" :value="__('Password')" :required="$method == 'POST' ? true : false" />
            </div>
            <x-text-input name="password" type="password" id="password" autofocus />
            <x-input-error class="mt-2" :messages="$errors->manageUserForm->get('password')" />
        </div>
        <!-- end::Password Input -->

        <!-- start::Confirm Password Input -->
        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" :required="$method == 'POST' ? true : false" />
            </div>
            <x-text-input name="password_confirmation" type="password" id="password_confirmation" autofocus />
            <x-input-error class="mt-2" :messages="$errors->manageUserForm->get('password')" />
        </div>
        <!-- end::Confirm Password Input -->
    </div>

    <div class="flex justify-end gap-2 pt-8 pb-5">
        <button
            class="px-4 py-2 text-sm text-indigo-500 transition duration-150 rounded bg-indigo-50 hover:bg-indigo-500 hover:text-white"
            @click="modalForm = false">
            Save
        </button>
    </div>
</form>
