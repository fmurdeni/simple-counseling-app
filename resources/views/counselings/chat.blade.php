<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="chat-app">
                        <ul id="messages">
                            <!-- Loop untuk menampilkan pesan -->
                        </ul>
                        <input type="text" id="message-input" placeholder="Type a message...">
                        <button id="send-button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        document.getElementById('send-button').addEventListener('click', () => {
            const message = document.getElementById('message-input').value;

            axios.post('/messages', { message }).then(response => {
                console.log(response.data);
            });
        });

        // Mengambil pesan dari server
        axios.get('/messages').then(response => {
            const messages = response.data;
            // Render pesan ke HTML
        });
    </script>
</x-app-layout>

