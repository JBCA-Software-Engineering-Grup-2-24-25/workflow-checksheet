<div>
    <form action="{{ route(name: 'roles.index', absolute: false) }}" method="get" class="flex items-center gap-3">
        @csrf
        <div>
            <x-text-input type="text" name="search" placeholder="Search..." :value="!empty($search) ? $search : ''" />
        </div>
        <div>
            <x-form.select name="sortBy" :options="$sortChoices" :defaultValue="$sortBy" />
        </div>
        <x-button type="submit" color="light-primary">{{ __('Filter') }}</x-button>
    </form>
</div>
