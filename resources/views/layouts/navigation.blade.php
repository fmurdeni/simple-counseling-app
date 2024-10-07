<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
        <!-- Mobile hamburger -->
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="toggleSideMenu" aria-label="Menu" >
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" ></path> </svg>
        </button>
        
        <div class="flex justify-center flex-1 lg:mr-32"></div>
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Theme toggler -->
            <li class="flex">
                <x-theme-toggler />
            </li>
            
            <!-- Profile menu -->
            <li class="relative">
                <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true" >
                    <img class="object-cover w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="" aria-hidden="true" />
                </button>
                <template x-if="isProfileMenuOpen">
                    <ul
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click.away="closeProfileMenu"
                        @keydown.escape="closeProfileMenu"
                        class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        aria-label="submenu"
                    >
                        <li class="flex">
                            <a
                                class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                href="{{ route('profile.edit') }}"
                            >
                                <svg
                                    class="w-4 h-4 mr-3"
                                    aria-hidden="true"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    ></path>
                                </svg>
                                <span>{{ __('Profil') }}</span>
                            </a>
                        </li>
                        
                        <li class="flex">
                            
                            
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                @method('POST')
                                <button type="submit" class="w-full flex items-center px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                    <svg class="w-4 h-4 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M21 12L13 12" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M18 15L20.913 12.087V12.087C20.961 12.039 20.961 11.961 20.913 11.913V11.913L18 9" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M16 5V4.5V4.5C16 3.67157 15.3284 3 14.5 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H14.5C15.3284 21 16 20.3284 16 19.5V19.5V19" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>
                                    
                                    {{ __('Keluar') }}
                                </button>
                                
                            </form>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>