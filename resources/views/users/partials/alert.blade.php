{{-- start::Alert  --}}
@if (session('status') === 'user-created')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('User has been Created successfully!') }}</span>
    </x-alert>
@elseif (session('status') === 'user-updated')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('User has been Updated successfully!') }}</span>
    </x-alert>
@elseif (session('status') === 'user-deleted')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('User has been Deleted successfully!') }}</span>
    </x-alert>
@elseif ($errors->manageUserForm->any())
    <x-alert type="danger" :show="true">
        <span class="font-medium">{{ __('Save Data unsuccessfully!') }}</span>
    </x-alert>
@endif
{{-- end::Alert --}}
