<a {{ $attributes->merge(['class' => 'inline-flex items-center text-sm font-medium bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple active:bg-purple-800 transition duration-150 ease-in-out dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:shadow-outline-purple dark:active:bg-purple-700']) }}>
    {{ $slot }}
</a>
