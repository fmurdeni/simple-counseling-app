<x-guest-layout>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        @if (isset($_GET['role']))
            <div class="flex items-center justify-center p-6 sm:p-12 w-full">
            
                <div class="w-full">
                    <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                    @if ($_GET['role'] == 1)
                        {{ __('Login Konselor') }}
                    @else
                        {{ __('Login Mahasiswa') }}
                    @endif
                    </h2>
                    <form method="POST" action="{{ route('login') }}"> 
                    @csrf
                        <div class="block text-sm">
                            <x-input-label class="block" for="email" :value="__('Alamat Email')" />
                            <x-input-text id="email" class="block w-full mt-1 text-sm text-gray-700 dark:text-gray-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            
                        </div>
                        
                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Kata Sandi')" />
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
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
                            </label>
                        </div>
                        <x-purple-button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center">
                            {{ __('Masuk') }}
                        </x-purple-button>
                        <hr class="my-5" />
                        
                            @if (Route::has('password.request'))
                                
                                <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('password.request') }}">
                                    {{ __('Lupa kata sandi?') }}
                                </a>
                            
                            @endif


                            @if ($_GET['role'] == 2)
                                
                                <p class="mt-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Belum memiliki akun?') }}</span>
                                    <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('register') }}">
                                        {{ __('Daftar') }}
                                    </a>
                                </p>

                                <p class="mt-4">
                                    
                                    <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('login') . '?role=1' }}">
                                        {{ __('Login sebagai konselor') }}
                                    </a>

                                </p>
                            @else

                                <p class="mt-4">
                                    <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('login') . '?role=2' }}">
                                        {{ __('Login sebagai mahasiswa') }}
                                    </a>
                                </p>

                            @endif
                        

                            
                        
                    </form>
                </div>
            </div>
        @else
        <div class="flex items-center justify-center p-6 sm:p-12 w-full">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200 uppercase" >{{ __('Sistem Informasi Konseling') }}</h1>
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 font-semibold">
                    {{ __('Sudah punya akun? pilih login di bawah ini') }}
                    
                </div>
                <div class="w-full flex gap-4">
                    <x-button-link-primary class="uppercase text-sm w-full justify-center" href="{{ route('login') . '?role=2' }}">{{ __('Login sebagai mahasiswa') }}</x-button-link-primary>
                    <x-button-link-secondary class="uppercase text-sm w-full justify-center" href="{{ route('login') . '?role=1' }}">{{ __('Login sebagai konselor') }}</x-button-link-primary>
                </div>
            </div
        </div>
        
        @endif
    </div>
   
</x-guest-layout>
