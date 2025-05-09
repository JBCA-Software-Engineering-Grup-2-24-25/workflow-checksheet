<aside :class="menuOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 bg-indigo-500 lg:translate-x-0 lg:inset-0 custom-scrollbar">
    <!-- start::Logo -->
    <div class="flex items-center justify-center h-16">
        <h1 class="text-xl font-bold tracking-widest text-gray-100 uppercase">
            {{ config('app.name') }}
        </h1>
    </div>
    <!-- end::Logo -->

    <!-- start::Navigation -->
    <nav class="py-10 custom-scrollbar space-y-2">
        <!-- start::Menu link -->
        <a x-data="{ linkActive: @js(in_array('/' . request()->segment(1), [route(name: 'index', absolute: false)]) ? true : false) }" href="{{ route(name: 'index', absolute: false) }}"
            class="flex items-center mx-4 px-3 py-3 text-gray-300 rounded transition duration-200"
            :class="linkActive ? 'bg-black bg-opacity-30 text-gray-100 cursor-default' :
                'cursor-pointer opacity-70 hover:opacity-100'">
            <svg class="transition duration-200 hover:text-gray-100" width="20" height="20" fill="none"
                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17 21.002H7a4 4 0 0 1-4-4V10.71a4 4 0 0 1 1.927-3.42l5-3.031a4 4 0 0 1 4.146 0l5 3.03A4 4 0 0 1 21 10.71v6.292a4 4 0 0 1-4 4Z">
                </path>
                <path d="M9 17h6"></path>
            </svg>
            <span class="ml-3 transition duration-200 hover:text-gray-100">
                Dashboard
            </span>
        </a>
        <!-- end::Menu link -->

        @canany(['roles.index', 'permission.index'])
            <div x-data="{ linkActive: @js(in_array('/' . request()->segment(1), [route(name: 'company.index', absolute: false), route(name: 'client.index', absolute: false), route(name: 'roles.index', absolute: false), route(name: 'permission.index', absolute: false)]) ? true : false) }">
                <div @click="linkActive = !linkActive"
                    class="flex items-center justify-between mx-4 px-3 py-3 rounded transition duration-200 text-white"
                    :class="linkActive ? 'bg-black bg-opacity-30 text-gray-100 cursor-default' :
                        'text-gray-300 cursor-pointer hover:text-gray-100 opacity-70 hover:opacity-100'">
                    <div class="flex items-center">
                        <svg class="transition duration-200 hover:text-gray-100" width="20" height="20"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 19c0-3.313-3.134-6-7-6-.807 0-2.103-.292-3-1.234"></path>
                            <path d="M15 13a4 4 0 1 0-3-6.646"></path>
                            <path d="M16 19c0-3.314-3.134-6-7-6s-7 2.686-7 6h14Z"></path>
                            <path d="M9 13a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
                        </svg>
                        <span class="ml-3">People</span>
                    </div>
                    <svg class="w-3 h-3 transition duration-300" :class="linkActive ? 'rotate-90' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <!-- start::Submenu -->
                <ul x-show="linkActive" x-cloak x-collapse.duration.300ms class="text-gray-300">
                    <!-- start::Submenu link -->
                    @can('roles.index')
                        <li class="py-2 pl-10 pr-6 transition duration-200 cursor-pointer opacity-70 hover:opacity-100">
                            <a href="{{ route(name: 'roles.index', absolute: false) }}" class="flex items-center">
                                <span class="mr-2 text-sm">&bull;</span>
                                <span class="overflow-ellipsis">Roles</span>
                            </a>
                        </li>
                    @endcan
                    <!-- end::Submenu link -->
                    <!-- start::Submenu link -->
                    @can('permission.index')
                        <li class="py-2 pl-10 pr-6 transition duration-200 cursor-pointer opacity-70 hover:opacity-100">
                            <a href="{{ route(name: 'permission.index', absolute: false) }}" class="flex items-center">
                                <span class="mr-2 text-sm">&bull;</span>
                                <span class="overflow-ellipsis">Permission</span>
                            </a>
                        </li>
                    @endcan
                    <!-- end::Submenu link -->
                </ul>
                <!-- end::Submenu -->
            </div>
            <!-- end::Menu link -->
        @endcanany

        <!-- start::Menu link -->
        <a x-data="{ linkActive: @js(in_array('/' . request()->segment(1), [route(name: 'notification.index', absolute: false)]) ? true : false) }" href="{{ route(name: 'notification.index', absolute: false) }}"
            class="flex items-center mx-4 px-3 py-3 rounded transition duration-200 text-white"
            :class="linkActive ? 'bg-black bg-opacity-30 text-gray-100 cursor-default' :
                'text-gray-300 cursor-pointer opacity-70 hover:opacity-100'">
            <svg class="transition duration-200 hover:text-gray-100" width="20" height="20" fill="none"
                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M18 8.4c0-1.697-.632-3.325-1.757-4.525C15.117 2.675 13.59 2 12 2c-1.591 0-3.117.674-4.243 1.875C6.632 5.075 6 6.703 6 8.4 6 15.867 3 18 3 18h18s-3-2.133-3-9.6Z">
                </path>
                <path d="M13.73 21a1.999 1.999 0 0 1-3.46 0"></path>
            </svg>
            <span class="ml-3 transition duration-200">
                Notification
            </span>
        </a>
        <!-- end::Menu link -->

        <!-- <p class="px-6 mt-10 mb-2 text-xs text-gray-300 uppercase">Apps</p> -->
    </nav>
    <!-- end::Navigation -->
</aside>
