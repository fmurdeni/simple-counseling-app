<button {{ $attributes->merge(['type' => 'submit', 'class' => 'active:bg-purple-600 bg-purple-600 border border-transparent duration-150 focus:outline-none focus:shadow-outline-purple font-medium hover:bg-purple-700 leading-5 p-4 py-2 rounded-lg text-sm text-white transition-colors x-4']) }}>
    {{ $slot }}
</button>
