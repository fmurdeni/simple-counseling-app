<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-md">
                <div class="p-6 text-gray-800 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
               
            </div>
        </div>
    </div>
</x-app-layout>
