<x-guest-layout>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        
        
        <div class="flex items-center justify-center p-6 sm:p-12 w-full">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200" >{{ __('Konfirmasi Kata Sandi') }}</h1>
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                     {{ __('Ini adalah area yang aman dari aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.') }}
                </div>
                
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Kata Sandi')" />

                        <x-input-text id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>
                            {{ __('Konfirmasi') }}
                        </x-primary-button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-guest-layout>

