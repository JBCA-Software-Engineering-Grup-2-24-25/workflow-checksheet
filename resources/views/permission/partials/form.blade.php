<section>
    <form class="mt-6 space-y-6" enctype="multipart/form-data" x-data="{
        form: $form(@js($method), '{{ $action }}', {
            name: '{{ old('name', isset($data['name']) ? $data['name'] : '') }}',
        })
    }">
        @csrf
        @method('PUT')

        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="name" :value="__('Name')" required />
            </div>
            <x-text-input id="name" name="name" type="text" class="block w-full mt-1" x-model="form.name"
                required autofocus autocomplete="name" @change="form.validate('name')" />
            <x-input-error class="mt-2" type="name" />
        </div>

        <div class="flex flex-col">
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input rows="5" type="textarea" id="description" name="description" class="block w-full mt-1"
                autofocus>
                {{ old('description', isset($data['description']) ? $data['description'] : '') }}
            </x-text-input>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button color="primary">{{ __('Save') }}</x-button>
        </div>
    </form>
</section>
