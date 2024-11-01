<x-guest-layout>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        
        <div class="flex items-center justify-center p-6 sm:p-12 w-full">
        <div class="w-full">
            <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200" >{{ __('Lupa kata sandi') }}</h1>
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Lupa kata sandi Anda? Tidak masalah. Tinggal beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi yang akan memungkinkan Anda memilih yang baru.') }}
            </div>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-input-text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-purple-button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center">
                        {{ __('Kirimkan tautan reset') }}
                    </x-primary-button>
                </div>
            </form>
            
            <x-auth-session-status class="mb-4 mt-4" :status="session('status')" />
        </div>
        </div>
    </div>
    
</x-guest-layout>

