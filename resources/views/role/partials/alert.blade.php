{{-- start::Alert  --}}
@if (session('status') === 'role-created')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('Role has been Created successfully!') }}</span>
    </x-alert>
@elseif (session('status') === 'role-updated')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('Role has been Updated successfully!') }}</span>
    </x-alert>
@elseif (session('status') === 'role-deleted')
    <x-alert type="success" :show="true">
        <span class="font-medium">{{ __('Role has been Deleted successfully!') }}</span>
    </x-alert>
@elseif ($errors->count())
    <x-alert type="danger" :show="true">
        <span class="font-medium">{{ __('Save Data unsuccessfully!') }}</span>
    </x-alert>
@endif
{{-- end::Alert --}}
