<div>
    @if ($messages->count() == 0)
        <p class="text-gray-400 dark:text-gray-400 text-sm">Belum ada pesan.</p>
    @else
        @foreach ($messages as $message)
            <x-message-item :message="$message" />
        @endforeach              
    @endif
</div>
