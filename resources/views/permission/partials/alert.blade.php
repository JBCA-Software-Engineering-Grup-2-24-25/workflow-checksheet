{{-- start::Alert --}}
@if (session('status') === 'permission-updated')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('Permission has been Updated successfully!') }}</span>
    </x-alert>
@elseif ($errors->count())
    <x-alert type="danger" :show="true">
        <span class="font-medium">{{ __('Save Data unsuccessfully!') }}</span>
    </x-alert>
@endif
{{-- end::Alert --}}
