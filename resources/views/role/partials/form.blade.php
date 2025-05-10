<form action="{{ $action }}" method="post" class="mt-6 space-y-6">
    @csrf
    @method($method)

    <div class="flex flex-col space-y-4">
        <!-- start::Name Input -->
        <div class="flex flex-col">
            <div class="flex">
                <x-input-label for="name" :value="__('Name')" required />
            </div>
            <x-text-input id="name" name="name" type="text" placeholder="Name..."
                class="mt-2 border-gray-300 py-1 focus:border-gray-300 focus:outline-none focus:ring-0" required autofocus
                autocomplete="name" :value="old('name', isset($data['name']) ? $data['name'] : '')" />
            <x-input-error class="mt-2" type="name" />
        </div>
        <!-- end::Name Input -->

        <div class="flex flex-col">
            <div class="flex">
                <x-input-label :value="__('Permissions')" class="font-normal" required />
            </div>
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
                                    <span class="font-semibold">{{ ucwords(str_replace('-', ' ', $name)) }}</span>
                                </x-table.data>
                                <x-table.data>
                                    <div class="flex items-end" x-data="checkAll()">
                                    <x-form.checkbox @click="selectAll(event)" />
                                    <span>Select All</span>
                                    </div>
                                </x-table.data>
                                <x-table.data />
                                <x-table.data />
                            </x-table.row>
                            {{-- Parent Row End --}}
                            {{-- Child Row Start --}}
                            @foreach ($menu as $item)
                                <x-table.row>
                                    <x-table.data>
                                    <span class="px-8 py-2"
                                        :class="{
                                            'opacity-50 cursor-not-allowed': {{ $item->is_default ? 'true' : 'false' }},
                                        }">{{ $item->name }}</span>
                                    </x-table.data>
                                    <x-table.data>
                                    <div x-data="checked()">
                                        @if ($item->is_default)
                                            <input type="hidden" name="permissions[]" value="{{ $item->id }}">
                                            <x-form.checkbox :checked="$item->is_default" :disabled="$item->is_default" />
                                        @else
                                            <x-form.checkbox name="permissions[]" value="{{ $item->id }}" :checked="isset($data)
                                                ? $data->permissions->where('id', $item->id)->count() > 0
                                                : false"
                                                @change="document.getElementById('{{ $item->route_prefix }}-parent').checked = collect(document.querySelectorAll('.{{ $item->route_prefix }}')).count() == collect(document.querySelectorAll('.{{ $item->route_prefix }}')).where('checked', true).count()" />
                                        @endif
                                    </div>
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
            <x-input-error class="mt-2" :messages="$errors->get('permissions.*')" />
        </div>

        <!-- button -->
        <div class="flex justify-end gap-2 pb-5 pt-8">
            <button
                class="rounded bg-indigo-50 px-4 py-2 text-sm text-indigo-500 transition duration-150 hover:bg-indigo-500 hover:text-white">
                Save
            </button>
        </div>
    </div>
</form>

@push('scripts')
    <script>
    document.addEventListener("alpine:init", () => {
        Alpine.data('checkAll', () => ({
            selectAll(event) {
                let isChecked = event.target.checked;

                let parentRow = event.target.closest('tr');

                let childCheckboxes = [];
                let nextRow = parentRow.nextElementSibling;

                while (nextRow && !nextRow.classList.contains('bg-gray-100')) {
                let checkbox = nextRow.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = isChecked;
                }
                nextRow = nextRow.nextElementSibling;
                }
            }
        }));

        Alpine.data('checked', () => ({
            toggleParent(menuPrefix) {
                let parentCheckbox = document.getElementById(`${menuPrefix}-parent`);
                let childCheckboxes = document.querySelectorAll(`.${menuPrefix}`);
                let allChecked = Array.from(childCheckboxes).every(cb => cb.checked);
                parentCheckbox.checked = allChecked;
            }
        }));
    });
    </script>
@endpush
