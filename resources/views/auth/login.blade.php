<x-guest-layout>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        
        <div class="flex items-center justify-center p-6 sm:p-12 w-full">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Login</h1>
                <form method="POST" action="{{ route('login') }}"> 
                @csrf
                    <div class="block text-sm">
                        <x-input-label class="block" for="email" :value="__('Email')" />
                        <x-input-text id="email" class="block w-full mt-1 text-sm text-gray-700 dark:text-gray-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                       
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        
                    </div>
                    
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-input-text id="password" class="block w-full mt-1 text-sm"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <x-input-checkbox id="remember_me" name="remember" class="" type="checkbox" name="remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <x-purple-button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center">
                        {{ __('Log in') }}
                    </x-purple-button>
                    <hr class="my-5" />
                    
                        @if (Route::has('password.request'))
                            
                            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                           
                        @endif

                        <p class="mt-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Don\'t have an account?') }}</span>
                            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </p>
                       

                        
                    
                </form>
            </div>
        </div>
    </div>
   
</x-guest-layout>