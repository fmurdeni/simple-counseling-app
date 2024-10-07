<section>
    
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        {{ __('Informasi Profil') }}
    </h4>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-input-text id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-input-text id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Klik disini untuk mengirimkan email verifikasi lagi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-input-text id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)"  autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- custom fields --}}
        @foreach(App\Models\UserCustomField::fields() as $field)
        <div>
            <x-input-label for="{{ $field['name'] }}" :value="$field['label']" />            
            
            @php
                $value = App\Models\UserCustomField::getValue($user->id, $field['name']);
            @endphp

            @if (in_array($field['type'], ['text', 'number', 'password', 'email', 'url', 'tel']))
                <x-input-text id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="{{ $field['type'] }}" class="mt-1 block w-full {{ $field['class'] ?? '' }}" :required="$field['required']" :value="$value" autocomplete="{{ $field['autocomplete'] ?? '' }}" />

            @elseif ($field['type'] === 'textarea')
                <x-input-textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="mt-1 block w-full {{ $field['class'] ?? '' }}" :required="$field['required']">{{ $value }}</x-input-textarea>

            @elseif ($field['type'] === 'select')
                <x-input-select id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="mt-1 block w-full {{ $field['class'] ?? '' }}" :required="$field['required']">
                    <option value="">{{ __('Pilih nilai') }}</option>
                    @foreach($field['options'] as $key => $label)
                        <option value="{{ $key }}" {{ ($value === $key) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </x-input-select>

            @elseif ($field['type'] === 'checkbox')
            @php
                $checkbox_value = $field['value'] ?? 1;
            @endphp

                <label class="mt-1 inline-flex gap-2"><x-input-checkbox type="checkbox" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="{{ $field['class'] ?? '' }}" :required="$field['required']" :value="$checkbox_value" :checked="($value === $checkbox_value)" />{{ $field['input_text'] }}</label>

            {{-- radio --}}
            @elseif ($field['type'] === 'radio')
                <div class="flex gap-2 mt-2">
                @foreach($field['options'] as $key => $label)

                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <x-input-radio id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="radio" class="{{ $field['class'] ?? '' }}" :value="$key" :checked="($value === $key)" />
                        <span class="ml-2">{{ $label }}</span>
                    </label>

                @endforeach
                </div>

            @endif
                
        </div>
        @endforeach

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

