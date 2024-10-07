<li class="relative px-6 py-3">

    @php $menu_item_class = 'inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200'; @endphp
    @php $isActive = (bool) $attributes->get('active', false); @endphp
    @if ($isActive)
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" ></span>
        @php $menu_item_class = 'inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100'; @endphp
    @endif
        
    <a class="{{ $menu_item_class }}" href="{{ $attributes->get('href', '#') }}" > 
        {{ $slot }}
    </a>
</li>