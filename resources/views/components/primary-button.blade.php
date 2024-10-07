<button {{ $attributes->merge(['type' => 'submit', 'class' => 'py-2 px-4 active:bg-purple-600 bg-purple-600 border border-transparent duration-150 focus:outline-none focus:shadow-outline-purple font-medium hover:bg-purple-700  rounded-lg text-white transition-colors']) }}>
    {{ $slot }}
</button>
