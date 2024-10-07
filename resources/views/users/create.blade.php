<x-app-layout>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Buat Pengguna Baru') }}
        </h2>
        <div class="w-full overflow-x-auto">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-md mb-4">
                <div class="w-full max-w-xl">
                    <section>
                        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                            {{ __('Informasi Profil') }}
                        </h4>

                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Nama')" />
                                <x-input-text id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="email" :value="__('Alamat Email')" />
                                <x-input-text id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                
                            </div>

                            <div class="mb-4">
                                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-input-text id="phone" name="phone" type="text" class="mt-1 block w-full" autocomplete="phone" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="role" :value="__('Peran Pengguna')" />
                                @php
                                    $roles = App\Models\Role::all()->pluck('name', 'id');
                                @endphp
                                @foreach($roles as $id => $name)
                                    <div class="mt-1">
                                        <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                            <x-input-checkbox name="roles[]" :value="$id" :checked="false" />
                                            <span class="ml-2">{{ $name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>
                    
                            {{-- custom fields --}}
                            @foreach(App\Models\UserCustomField::fields() as $field)
                            <div class="mb-4">
                                <x-input-label for="{{ $field['name'] }}" :value="$field['label']" />

                                @if (in_array($field['type'], ['text', 'number', 'password', 'email', 'url', 'tel']))
                                    <x-input-text id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="{{ $field['type'] }}" class="mt-1 block w-full {{ $field['class'] ?? '' }}" :required="$field['required']" autocomplete="{{ $field['autocomplete'] ?? '' }}" />

                                @elseif ($field['type'] === 'textarea')
                                    <x-input-textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="mt-1 block w-full {{ $field['class'] ?? '' }}" :required="$field['required']"></x-input-textarea>

                                @elseif ($field['type'] === 'select')
                                    <x-input-select id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="mt-1 block w-full {{ $field['class'] ?? '' }}" :required="$field['required']">
                                        <option value="">{{ __('Pilih Nilai') }}</option>
                                        @foreach($field['options'] as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </x-input-select>

                                @elseif ($field['type'] === 'checkbox')                               

                                    <label class="mt-1 inline-flex gap-2"><x-input-checkbox type="checkbox" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="{{ $field['class'] ?? '' }}" :required="$field['required']" :value="$checkbox_value" />{{ $field['input_text'] }}</label>

                                {{-- radio --}}
                                @elseif ($field['type'] === 'radio')
                                    <div class="flex gap-2 mt-2">
                                    @foreach($field['options'] as $key => $label)

                                        <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                            <x-input-radio id="{{ $field['name'].'_'.$key }}" name="{{ $field['name'] }}" type="radio" class="{{ $field['class'] ?? '' }}" :value="$key" />
                                            <span class="ml-2">{{ $label }}</span>
                                        </label>

                                    @endforeach
                                    </div>

                                @endif
                                    
                            </div>
                            @endforeach
                            
                            <div class="mb-4">
                                <x-input-label for="update_password_password" :value="__('Kata Sandi')" />
                                <x-input-text id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                <x-input-text id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>


                            <div class="flex items-center gap-4">
                                
                                <x-button>{{ __('Simpan') }}</x-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Tersimpan.') }}</p>
                                @endif
                            </div>


                        </form>
                    </section>

                </div>
            </div>           
           
            
        </div>
       
    </div>
</x-app-layout>

