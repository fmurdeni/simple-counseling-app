<x-app-layout>
    @if (Auth::user()->id !== $counseling->user_id && !auth()->user()->hasRole(1))
        @php
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        @endphp
    @endif
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Edit Konseling') }}
        </h2>
        <div class="w-full overflow-x-auto">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-md mb-4">
                <div class="w-full max-w-xl">
                    <section>
                        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                            {{ __('Informasi Konseling') }}
                        </h4>
                        <form method="POST" action="{{ route('counselings.update', $counseling) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Topik')" />
                                <x-input id="topic" class="block mt-1 w-full" type="text" name="topic" :value="old('topic', $counseling->topic)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('topic')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Preferensi Waktu')" />
                                <x-input-select id="time_preference" class="block mt-1 w-full" type="text" name="time_preference" required autofocus>
                                    <option value="morning" {{ old('time_preference', $counseling->time_preference) === 'morning' ? 'selected' : '' }}>{{ __('08.00 - 11.30') }}</option>
                                    <option value="afternoon" {{ old('time_preference', $counseling->time_preference) === 'afternoon' ? 'selected' : '' }}>{{ __('12.30 - 15.00') }}</option>
                                    <option value="evening" {{ old('time_preference', $counseling->time_preference) === 'evening' ? 'selected' : '' }}>{{ __('16.00 - 17.00') }}</option>
                                </x-input-select>
                                <x-input-error class="mt-2" :messages="$errors->get('time_preference')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Deskripsi')" />
                                <x-input-textarea id="description" class="block mt-1 w-full" type="text" name="description" required autofocus >{{ old('description', $counseling->description) }}</x-input-textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                            

                            <x-button type="submit" class="mt-4 uppercase">
                                {{ __('Update Konseling') }}
                            </x-button>

                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

