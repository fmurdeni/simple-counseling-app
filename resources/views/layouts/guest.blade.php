<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="{ 'theme-dark': dark }" x-data="data()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',            
            'resources/css/common.css',
            'resources/css/tailwind.output.css',
            'resources/js/app.js', 
            ])
    </head>
    <body class="font-sans text-gray-900 antialiased">
    <div class="relative">
        <x-theme-toggler class="absolute top-4 right-4" />
        <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">   
            <div class="flex-1 h-full max-w-2xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800 w-full max-w-12">
                <div class="container px-6 mx-auto mt-4">
                            
                    @if(session('success'))
                        <div class="alert alert-success bg-green-500 flex focus:outline-none focus:shadow-outline-purple font-semibold items-center justify-between p-2 rounded-md shadow-md text-white text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger bg-red-600 flex focus:outline-none focus:shadow-outline-purple font-semibold items-center justify-between p-2 rounded-md shadow-md text-white text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                </div>

                {{ $slot }}
            </div>


        </div>
    </div>
        <script>
            function data() {
                function getThemeFromLocalStorage() {
                    // if user already changed the theme, use it
                    if (window.localStorage.getItem("dark")) {
                        return JSON.parse(window.localStorage.getItem("dark"));
                    }

                    // else return their preferences
                    return (
                        !!window.matchMedia &&
                        window.matchMedia("(prefers-color-scheme: dark)").matches
                    );
                }

                function setThemeToLocalStorage(value) {
                    window.localStorage.setItem("dark", value);
                }

                return {
                    dark: getThemeFromLocalStorage(),
                    toggleTheme() {
                        this.dark = !this.dark;
                        setThemeToLocalStorage(this.dark);
                    },
                    isSideMenuOpen: false,
                    toggleSideMenu() {
                        this.isSideMenuOpen = !this.isSideMenuOpen;
                    },
                    closeSideMenu() {
                        this.isSideMenuOpen = false;
                    },
                    isNotificationsMenuOpen: false,
                    toggleNotificationsMenu() {
                        console.log(this.isNotificationsMenuOpen);
                        this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
                    },
                    closeNotificationsMenu() {
                        this.isNotificationsMenuOpen = false;
                    },
                    isProfileMenuOpen: false,
                    toggleProfileMenu() {
                        this.isProfileMenuOpen = !this.isProfileMenuOpen;
                    },
                    closeProfileMenu() {
                        this.isProfileMenuOpen = false;
                    },
                    isPagesMenuOpen: false,
                    togglePagesMenu() {
                        this.isPagesMenuOpen = !this.isPagesMenuOpen;
                    },
                    // Modal
                    isModalOpen: false,
                    trapCleanup: null,
                    openModal() {
                        this.isModalOpen = true;
                        this.trapCleanup = focusTrap(document.querySelector("#modal"));
                    },
                    closeModal() {
                        this.isModalOpen = false;
                        this.trapCleanup();
                    },
                };
            }

            function focusTrap(element) {
                const focusableElements = getFocusableElements(element);
                const firstFocusableEl = focusableElements[0];
                const lastFocusableEl = focusableElements[focusableElements.length - 1];

                // Wait for the case the element was not yet rendered
                setTimeout(() => firstFocusableEl.focus(), 50);

                /**
                * Get all focusable elements inside `element`
                * @param {HTMLElement} element - DOM element to focus trap inside
                * @return {HTMLElement[]} List of focusable elements
                */
                function getFocusableElements(element = document) {
                    return [
                        ...element.querySelectorAll(
                            'a, button, details, input, select, textarea, [tabindex]:not([tabindex="-1"])'
                        ),
                    ].filter((e) => !e.hasAttribute("disabled"));
                }

                function handleKeyDown(e) {
                    const TAB = 9;
                    const isTab = e.key.toLowerCase() === "tab" || e.keyCode === TAB;

                    if (!isTab) return;

                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusableEl) {
                            lastFocusableEl.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusableEl) {
                            firstFocusableEl.focus();
                            e.preventDefault();
                        }
                    }
                }

                element.addEventListener("keydown", handleKeyDown);

                return function cleanup() {
                    element.removeEventListener("keydown", handleKeyDown);
                };
            }


        </script>
    </body>
</html>
