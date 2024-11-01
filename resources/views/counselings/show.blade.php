<x-app-layout>
    @if ($counseling->user_id !== auth()->user()->id && !auth()->user()->hasRole(1))
        @php
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        @endphp
    @endif

    
    <div class="container grid px-6 mx-auto">
            
        <div class="flex items-center gap-2">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Topik: ') }} {{ $counseling->topic }}
            </h1>

            <div class="text-ms text-gray-600 dark:text-gray-400">
                @if ($counseling->status === 'pending')
                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-300 dark:bg-gray-700"> {{ __('Menunggu tanggapan konselor') }} </span>
                @elseif ($counseling->status === 'approved')
                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> {{ __('Disetujui') }} </span>
                @elseif ($counseling->status === 'rejected')
                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"> {{ __('Ditolak') }} </span>
                @elseif ($counseling->status === 'ongoing')
                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-green-100 rounded-full dark:text-gray-300 dark:bg-gray-700"> {{ __('Sedang berlangsung') }} </span>
                @elseif ($counseling->status === 'completed')
                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-blue-100 rounded-full dark:text-gray-300 dark:bg-gray-700"> {{ __('Selesai') }} </span>
                @endif

            </div>

        </div>

        <div class="mt-4 flex items-center justify-between mb-2">
            
            <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                {{ __('Informasi Konseling') }}
            
               </h2>

            <div class="flex items-center space-x-1 text-xs justify-end">
                @role('1')
                @if ($counseling->status === 'pending')
                    <form method="POST" action="{{ route('counselings.approve', $counseling->id) }}">
                        @csrf
                        <x-primary-button class="uppercase text-xs py-1">{{ __('Setujui') }}</x-button>
                    </form>
                    <form method="POST" action="{{ route('counselings.reject', $counseling->id) }}">
                        @csrf
                        <x-danger-button class="uppercase text-xs">{{ __('Tolak') }}</x-button>
                    </form>                                 
                @endif
                @endrole

                @if (Auth::user()->id == $counseling->user_id || Auth::user()->hasRole('1'))
                    
                    <form method="POST" class="delete-form" action="{{ route('counselings.destroy', $counseling) }}">
                        @csrf
                        @method('DELETE')
                        <x-secondary-button type="submit" class="uppercase text-xs">{{ __('Hapus') }}</x-button>
                    </form>
                
                    @if ($counseling->status !== 'completed')
                        <x-button-link href="{{ route('counselings.edit', $counseling) }}" class="py-2 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-gray-700 dark:text-gray-300 border border-transparent duration-150 focus:outline-none rounded-lg text-white transition-colors focus:shadow-outline-gray hover:bg-gray-100 dark:hover:bg-gray-700 focus:shadow-outline-gray uppercase text-xs"> {{ __('Edit') }} </x-button-link>
                        
                    @endif
                @endif

                

            </div>
        </div>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs bg-white dark:bg-gray-800">
            <div class="w-full overflow-x-auto">
                <div class="p-6">
                    <div class="block mb-2">
                        <p class="text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">{{  __('Pengirim: ') }}</span>
                            
                            @php
                                $user_id = $counseling->user_id;
                                $user = App\Models\User::find($user_id);
                                $name = $user->name;
                            @endphp

                            <span class="text-gray-700 dark:text-gray-400 font-semibold">{{ $name }}</span>
                        </p>

                        @role('1')
                        <p class="text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">{{  __('Urgensi Level: ') }}</span>
                            @if ($counseling->level === 'low')
                                <span class="text-green-500 dark:text-green-400 font-semibold"> {{ __('Rendah') }} </span>
                            @elseif ($counseling->level === 'medium')
                                <span class="text-yellow-500 dark:text-yellow-400 font-semibold"> {{ __('Sedang') }} </span>
                            @elseif ($counseling->level === 'high')
                                <span class="text-red-500 dark:text-red-400 font-semibold"> {{ __('Tinggi') }} </span>
                            @endif
                        </p>
                        
                         <p class="text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">{{  __('Sentimen: ') }}</span>
                            <x-emotion-display class="text-gray-500 dark:text-gray-400" :emotion="$counseling->sentiment"  />
                        </p>
                        @endrole

                        <p class="text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">{{  __('Preferensi waktu: ') }}</span>
                            @if ($counseling->time_preference === 'morning')
                                <span class="font-semibold"> {{ __('08.00 - 11.30') }} </span>
                            @elseif ($counseling->time_preference === 'afternoon')
                                <span class="font-semibold"> {{ __('12.30 - 15.00') }} </span>
                            @elseif ($counseling->time_preference === 'evening')
                                <span class="font-semibold"> {{ __('15.30 - 17.00') }} </span>
                            @endif
                        </p>
                    </div>

                    <h2 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                        {{ __('Deskripsi') }}
                    </h2>
                    <div class="mt-4">
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ $counseling->description }}
                        </p>

                        <p class="text-gray-500 dark:text-gray-400 italic text-sm mt-2">
                            {{ __('Dibuat pada') }} {{ $counseling->created_at->diffForHumans() }}
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>

        @role(1)
        <div class="w-full mb-8 overflow-hidden">
            @if ($counseling->status === 'approved')
                <form method="POST" action="{{ route('counselings.start', $counseling->id) }}">
                    @csrf
                    <x-primary-button type="submit">
                        {{ __('Mulai Sesi') }}
                    </x-primary-button>
                </form> 
            @endif

            @if ($counseling->status === 'ongoing')
                <form method="POST" action="{{ route('counselings.end', $counseling->id) }}">
                    @csrf
                    <x-primary-button type="submit">
                        {{ __('Selesaikan Sesi') }}
                    </x-primary-button>
                </form>
            @endif
            
        </div>
        @endrole
        
        @if ($counseling->status === 'ongoing' || $counseling->status === 'completed' )
            <div class="w-full mb-8">
                <h2 class="mb-4 mt-10 text-lg font-semibold text-gray-600 dark:text-gray-300">
                    {{ __('Percakapan') }}
                </h2>

                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs bg-blue-100 dark:bg-gray-800">
                    <div class="w-full overflow-x-auto">
                        <div class="p-6">
                            
                            <div class="block mb-2 messages-display mb-8 min-h-40 max-h-xl overflow-y-auto">
                                <x-message-items :messages="$messages" />
                            </div>

                            @if ($counseling->status === 'ongoing' && (Auth::user()->id === $counseling->user_id || Auth::user()->hasRole('1')))
                                
                                <div class="block mb-2">
                                    <form method="POST" id="message-form" action="{{ route('messages.store', $counseling->id) }}">
                                        @csrf
                                        <div class="flex items-end">
                                            <div class="flex-1">
                                                <x-input-textarea id="message-input" class="block mt-1 w-full" type="text" name="message" placeholder="Ketik Pesan..." required autofocus />
                                                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                                            </div>

                                            <div class="ml-4 bottom-0 right-0">
                                                <input type="hidden" id="counseling_id" name="counseling_id" value="{{ $counseling->id }}" />
                                                <x-secondary-button type="submit" class="uppercase text-xs py-1">{{ __('Kirim') }}</x-button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                            <p class="text-gray-400 dark:text-gray-400 italic text-sm">
                                {{ __('Anda tidak bisa mengirim pesan.') }}
                            </p>
                            @endif

                        </div>
                    </div>

                </div>
            
            </div>
        @endif


    </div>
</x-app-layout>

