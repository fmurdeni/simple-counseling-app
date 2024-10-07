<button {{ $attributes->merge(['type' => 'submit', 'class' => 'py-2 px-4 active:bg-red-600 bg-red-600 border border-transparent duration-150 focus:outline-none focus:shadow-outline-red font-medium hover:bg-red-700  rounded-lg text-white transition-colors']) }}>
    {{ $slot }}
</button>
