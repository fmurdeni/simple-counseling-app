<x-guest-layout>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        
        <div class="flex items-center justify-center p-6 sm:p-12 w-full">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200" >{{ __('Register') }}</h1>
                 <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input-text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-input-text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-input-text id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input-text id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    
                    <div class="flex mt-6 text-sm">
                        <label class="flex items-center dark:text-gray-400">
                            <input
                                type="checkbox"
                                class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            />
                            <span class="ml-2">
                                I agree to the
                                <span class="underline">privacy policy</span>
                            </span>
                        </label>
                    </div>

                    <x-purple-button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center">
                        {{ __('Register') }}
                    </x-primary-button>
                </form>


                <hr class="my-8" />
                

                <p class="mt-4">
                    <a
                        class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                        href="{{ route('login') }}"
                    >
                        {{ __('Already registered? Log in') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
   
</x-guest-layout>
