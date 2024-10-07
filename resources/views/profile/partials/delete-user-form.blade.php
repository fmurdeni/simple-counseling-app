<section class="space-y-6">
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        {{ __('Hapus Akun') }}
    </h4>
    
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Jika akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, silakan unduh data atau informasi yang ingin Anda simpan.') }}
        </p>
        
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h4>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Jika akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-input-text
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

