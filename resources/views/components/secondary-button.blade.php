<button {{ $attributes->merge(['type' => 'button', 'class' => 'py-2 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-gray-700 dark:text-gray-300 border border-transparent duration-150 focus:outline-none rounded-lg text-white transition-colors focus:shadow-outline-gray hover:bg-gray-100 dark:hover:bg-gray-700 focus:shadow-outline-gray']) }}>
    {{ $slot }}
</button>
