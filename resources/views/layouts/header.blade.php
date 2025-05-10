<div class="flex flex-col">
    <header class="flex items-center justify-between h-16 px-6 py-4 bg-white">
        <!-- start::Mobile menu button -->
        <div class="flex items-center">
            <button @click="menuOpen = true"
                class="text-gray-500 transition duration-200 hover:text-primary focus:outline-none lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                    </path>
                </svg>
            </button>
        </div>
        <!-- end::Mobile menu button -->

        <!-- start::Right side top menu -->
        <div class="flex items-center">
            <!-- start::Profile -->
            <div x-data="{ linkActive: false }" class="relative">
                <!-- start::Main link -->
                <div @click="linkActive = !linkActive" class="cursor-pointer">
                    {{ auth()->user()->name }}
                </div>
                <!-- end::Main link -->

                <!-- start::Submenu -->
                <div x-show="linkActive" @click.away="linkActive = false" x-cloak
                    class="absolute right-0 z-20 w-40 border border-gray-300 top-11">
                    <!-- start::Submenu content -->
                    <div class="bg-white rounded">
                        <!-- start::Submenu link -->
                        <a href="{{ route(name: 'profile.edit', absolute: false) }}"
                            class="flex items-center justify-between px-3 py-2 hover:bg-gray-100 bg-opacity-20">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <div class="ml-3 text-sm">
                                    <p class="font-bold text-gray-600 capitalize hover:text-primary">
                                        Profile
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!-- end::Submenu link -->

                        <hr />

                        <!-- start::Submenu link -->
                        <form method="POST" action="{{ route(name: 'logout', absolute: false) }}"
                            class="flex items-center justify-between px-3 py-2 hover:bg-gray-100 bg-opacity-20">
                            @csrf
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <x-dropdown-link :href="route(name: 'logout', absolute: false)"
                                    onclick="event.preventDefault();
											this.closest('form').submit();"
                                    class="ml-3 text-sm font-bold text-gray-600 capitalize">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </div>
                        </form>
                        <!-- end::Submenu link -->
                    </div>
                    <!-- end::Submenu content -->
                </div>
                <!-- end::Submenu -->
            </div>
            <!-- end::Profile -->
        </div>
        <!-- end::Right side top menu -->
    </header>
</div>
