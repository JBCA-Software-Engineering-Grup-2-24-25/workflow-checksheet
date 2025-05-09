<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Laravel') }} | Roles | {{ $data->name }}
    </x-slot>

    {{-- Alert Start --}}
    @include('role.partials.alert')
    {{-- Alert End --}}
    <div x-data="{ modalNewUserForm: false, actions: false, modalUpdateRoleForm: false, openDeleteRolesUser: false }">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <ol class="flex gap-3 text-sm">
                    <li class="text-gray-500 breadcrumb-item"> <a href="javascript:void(0)">Home</a> </li>
                    <li class="text-gray-500 breadcrumb-item"><a
                            href="{{ route(name: 'roles.index', absolute: false) }}">Roles</a></li>
                    <li class="text-indigo-500 breadcrumb-item active" aria-current="page">{{ $data->name }}</li>
                </ol>
            </div>
        </div>

        {{-- Start:: Roles Detail --}}
        <div class="w-full px-8 py-5 space-y-4 bg-white rounded-lg">
            <div class="flex justify-between">
                <span class="font-medium">{{ $data->name }}</span>
                {{-- start::Action Dropdown --}}
                @can('roles.update', $data)
                    <div class="relative flex items-center gap-3">
                        <div class="cursor-pointer" @click="actions = !actions">
                            <svg fill="#000" stroke="currentColor" height="15px" version="1.1" id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 32.055 32.055" xml:space="preserve">
                                <g>
                                    <path
                                        d="M3.968,12.061C1.775,12.061,0,13.835,0,16.027c0,2.192,1.773,3.967,3.968,3.967c2.189,0,3.966-1.772,3.966-3.967 C7.934,13.835,6.157,12.061,3.968,12.061z M16.233,12.061c-2.188,0-3.968,1.773-3.968,3.965c0,2.192,1.778,3.967,3.968,3.967 s3.97-1.772,3.97-3.967C20.201,13.835,18.423,12.061,16.233,12.061z M28.09,12.061c-2.192,0-3.969,1.774-3.969,3.967 c0,2.19,1.774,3.965,3.969,3.965c2.188,0,3.965-1.772,3.965-3.965S30.278,12.061,28.09,12.061z" />
                                </g>
                            </svg>
                        </div>
                        <!-- start::Dropdown Menu Modal -->
                        <div x-show="actions" @click.away="actions = false" x-cloak
                            class="absolute top-0 z-10 border border-gray-300 right-8">
                            <!-- start::Dropdown content -->
                            <div class="overflow-y-scroll bg-white rounded max-h-96 custom-scrollbar">
                                <!-- start::Dropdown link -->
                                <a href="{{ route(name: 'roles.edit', parameters: ['role_user' => $data->id], absolute: false) }}"
                                    class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-gray-100 bg-opacity-20">
                                    Edit
                                </a>
                                <!-- end::Dropdown link -->
                            </div>
                            <!-- end::Dropdown content -->
                        </div>
                        <!-- end::Dropdown Menu Modal -->
                    </div>
                @endcan
                {{-- end::Action Dropdown --}}
            </div>
            <div class="flex flex-col gap-5 mt-8">
                <div class="mt-2">
                    <span class="text-lg">Permissions</span>

                    <div>
                        <x-table>
                            <x-slot name="tableHeaders">
                                <x-table.header>
                                    {{ __('Name') }}
                                </x-table.header>
                                <x-table.header>
                                    {{ __('Permission') }}
                                </x-table.header>
                                <x-table.header>
                                    {{ __('Description') }}
                                </x-table.header>
                            </x-slot>
                            <x-slot name="tableBody">
                                @foreach ($permissions as $name => $menu)
                                    {{-- Parent Row Start --}}
                                    <x-table.row class="bg-gray-100">
                                        <x-table.data>
                                            <span class="font-semibold">{{ucwords(str_replace('-', ' ', $name))}}</span>
                                        </x-table.data>
                                        <x-table.data />
                                        <x-table.data />
                                    </x-table.row>
                                    {{-- Parent Row End --}}
                                    {{-- Child Row Start --}}
                                    @foreach ($menu as $item)
                                        <x-table.row class="opacity-50 cursor-not-allowed">
                                            <x-table.data>
                                                <span class="py-2 px-8">{{ $item->name }}</span>
                                            </x-table.data>
                                            <x-table.data>
                                                @if ($item->is_default == true)
                                                    <x-checkbox checked="checked" disabled="disabled" />
                                                @else
                                                    <x-checkbox :checked="$data->permissions->where('id', $item->id)->count() > 0 ||
                                                        $data->permissions->where('route', 'superadmin')->count() > 0
                                                            ? true
                                                            : false" disabled="disabled" />
                                                @endif
                                                {{-- <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" checked> --}}
                                            </x-table.data>
                                            <x-table.data>
                                                <span>{{ $item->description }}</span>
                                            </x-table.data>
                                        </x-table.row>
                                    @endforeach
                                    {{-- Child Row End --}}
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End:: Roles Detail --}}
    </div>
</x-app-layout>
