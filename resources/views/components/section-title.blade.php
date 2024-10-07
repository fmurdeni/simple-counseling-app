<div class="space-y-2 pt-6 pb-8 md:space-y-5">
    <h2 class="text-3xl font-extrabold leading-tight text-gray-900 dark:text-gray-100">
        {{ $title }}
    </h2>
    {{-- check if there is a description --}}
    @if (isset($description))
        <p class="text-lg leading-7 text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif
</div>
