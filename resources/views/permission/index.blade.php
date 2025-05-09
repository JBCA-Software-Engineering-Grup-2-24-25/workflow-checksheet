<x-app-layout>
    @include('permission.partials.alert')
    <x-slot name="header">
        {{ config('app.name', 'Laravel') }} | Permissions | List Permission
    </x-slot>
    <div>
        <x-breadcrumbs>
            <x-breadcrumbs.item :isActive="true" name="Permission" />
        </x-breadcrumbs>
        <x-header title="Permission" />
        <div class="px-8 py-6 mt-6 overflow-x-scroll bg-white rounded-lg custom-scrollbar">
            <div class="flex items-center justify-end">
                @include('permission.partials.filter-form', [
                    'search' => $search,
                    'sortChoices' => $sortChoices,
                    'sortBy' => $sortBy,
                ])
            </div>
            <div>
                <x-table>
                    <x-slot name="tableHeaders">
                        <x-table.header>
                            {{ __('Name') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('Description') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('Action') }}
                        </x-table.header>
                    </x-slot>
                    <x-slot name="tableBody">
                        @foreach ($data as $item)
                            <x-table.row>
                                <x-table.data>{{ $item->name }}</x-table.data>
                                <x-table.data>{{ $item->description ?? '' }}</x-table.data>
                                <x-table.actions>
                                    @can('permission.update', $item)
                                        <div class="flex items-center justify-start gap-2">
                                            <a href="{{ route(name: 'permission.edit', parameters: ['permission' => $item->id], absolute: false) }}"
                                                class="px-4 py-2 text-xs font-medium text-yellow-500 transition duration-150 rounded bg-yellow-50 hover:bg-yellow-500 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                    height="18">
                                                    <path
                                                        d="M6.41421 15.89L16.5563 5.74785L15.1421 4.33363L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21231C14.8256 1.82179 15.4587 1.82179 15.8492 2.21231L18.6777 5.04074C19.0682 5.43126 19.0682 6.06443 18.6777 6.45495L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endcan
                                </x-table.actions>
                            </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
            </div>
            {{$data->appends(request()->query())->links()}}
        </div>
    </div>
</x-app-layout>
