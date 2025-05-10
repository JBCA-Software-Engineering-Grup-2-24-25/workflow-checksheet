<x-app-layout>
    <!-- Page Header -->
    <x-breadcrumbs>
        <x-breadcrumbs.item :url="route(name: 'users.index', absolute: false)" name="Users" />
        <x-breadcrumbs.item :isActive="true" :name="$user->name" />
    </x-breadcrumbs>
    {{-- start::Alert --}}
    @include('users.partials.alert')
    {{-- end::Alert --}}

    <!-- start:Page content -->
    <div class="mx-4" x-data="{ openDelete: false, userId: 0 }">
        <div class="flex flex-col mt-4 mb-8 space-y-4 2xl:flex-row 2xl:space-y-0 2xl:space-x-4">
            <div class="pb-8 bg-white rounded-lg shadow-xl 2xl:w-1/2">
                <div class="w-full h-[250px]">
                    <img src="https://source.unsplash.com/500x250/?colorfull-wallpaper"
                        class="w-full h-full rounded-tl-lg rounded-tr-lg" />
                </div>
                <div class="flex flex-col items-center -mt-20">
                    <div class="mt-2">
                        <p class="text-2xl">{{ $user->name }}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full 2xl:w-1/2">
                <div class="flex flex-col justify-between flex-1 p-5 bg-white rounded-lg shadow-xl">
                    <div>
                        <h4 class="text-base font-semibold">Personal Info</h4>
                        <ul class="mt-2">
                            <li class="flex py-3 border-b">
                                <span class="w-24 text-base font-medium">Email:</span>
                                <span
                                    class="text-gray-700">{{  $user->email }}</span>
                            </li>
                            <li class="flex py-3 border-b">
                                <span class="w-24 text-base font-medium">Role:</span>
                                <span
                                    class="text-gray-700">{{  $user->role->name }}</span>
                            </li>
                            <li class="flex py-3 border-b">
                                <span class="w-24 text-base font-medium">Joined:</span>
                                <span class="text-gray-700">
                                    {{ $user->created_at->format('D / d-M-Y') }}
                                    ({{ $user->created_at->diffForHumans() }})
                                </span>
                            </li>
                            <li class="flex py-3 border-b">
                                <span class="w-24 text-base font-medium">Last seen at:</span>
                                <span class="text-gray-700">
                                    {{ $user->last_seen_at != null ? $user->last_seen->diffForHumans() : 'Now' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    @can('user.update', $user)
                        <div class="flex gap-3 ml-auto">
                            <a href="{{ route(name: 'users.edit', parameters: ['user' => $user->id], absolute: false) }}"
                                {{-- <a :href="route('user.edit', [$company['id'], $user['id']])" --}}
                                class="px-3 py-2 text-xs font-semibold text-yellow-600 transition duration-150 rounded bg-yellow-50 hover:bg-yellow-500 hover:text-white">
                                Update Profile
                            </a>
                        </div>
                    @endcan
                    @can('user.delete', $user)
                        <button
                            class="px-4 py-2 text-xs font-medium text-red-500 transition duration-150 rounded bg-red-50 hover:bg-red-500 hover:text-white"
                            @click="openDelete = true; userId = @js($user->id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                height="18">
                                <path
                                    d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 4V6H15V4H9Z"
                                    fill="currentColor"></path>
                            </svg>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
        <div x-show="openDelete"
            class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full overflow-x-hidden overflow-y-auto bg-black bg-opacity-80 md:inset-0 h-modal md:h-full"
            x-transition.opacity x-transition:enter.duration.100ms x-transition:leave.duration.300ms x-cloak>
            <div class="relative w-full h-full max-w-md p-4 md:h-auto" @click.away="openDelete = false">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
                    <button type="button" @click="openDelete = false"
                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="deleteModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-red-600 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="mb-4 ">Are you sure you want to delete this item?</p>
                    <div class="flex items-center justify-center space-x-4">
                        <form :action="route('user.destroy', { 'user_id': userId }, false)" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button color="primary" type="submit">
                                Yes, I'm sure
                            </x-button>
                        </form>
                        <button @click="openDelete = false"
                            class="px-3 py-2 text-sm font-medium bg-white border border-black rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10">
                            No, cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:Page content -->
</x-app-layout>
