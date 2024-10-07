<x-app-layout>
    <div class="container grid px-6 mx-auto">

        <div class="mt-4 flex items-center justify-between mb-6">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Daftar Konseling') }}
            </h2>
            <x-button-link-primary href="{{ route('counselings.create') }}">
                {{ __('Tambah Konseling') }}
            </x-button-link-primary>        
        </div>
        

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                @if($counselings->isEmpty())
                    <div class="w-full overflow-x-auto p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-md">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('Tidak ada konseling yang tersedia.') }}</p>
                    </div>
                @else
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-2">{{ __('Topik') }}</th>                                
                                <th class="px-4 py-2 text-center w-1">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800">
                            @foreach($counselings as $counseling)
                                @php
                                    $user_id = $counseling->user_id;
                                    $user = App\Models\User::find($user_id);
                                    $name = $user->name;
                                @endphp
                                <tr class="text-gray-700 dark:text-gray-400 text-sm">
                                    <td class="px-4 py-2">
                                        <div class="flex items-center text-sm gap-x-2">
                                            <a href="{{ route('counselings.show', $counseling) }}" class="font-semibold text-lg text-purple-500 hover:underline">{{ $counseling->topic }}</a>
                                            
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
                                        <p class="text-xs text-gray-600 dark:text-gray-400 italic mt-2">
                                            {{ __('Dikirim ') }} {{ $counseling->created_at->diffForHumans() }}
                                            @php
                                                $user_id = $counseling->user_id;
                                                $user = App\Models\User::find($user_id);
                                                $name = $user->name;
                                            @endphp

                                            {{ __('oleh') }} <span class="text-gray-700 dark:text-gray-400">{{ $name }}</span>
                                        </p>
                                        <p class="description mt-2 mb-2 text-sm text-gray-600 dark:text-gray-400" style="text-wrap: wrap">
                                            {{ Str::limit($counseling->description, 200) }}
                                        </p>

                                        @role('1')
                                        <p class="text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">{{  __('Urgensi: ') }}</span>
                                            @if ($counseling->level === 'low')
                                                <span class="text-green-500 dark:text-green-400 font-semibold"> {{ __('Rendah') }} </span>
                                            @elseif ($counseling->level === 'medium')
                                                <span class="text-yellow-500 dark:text-yellow-400 font-semibold"> {{ __('Sedang') }} </span>
                                            @elseif ($counseling->level === 'high')
                                                <span class="text-red-500 dark:text-red-400 font-semibold"> {{ __('Tinggi') }} </span>
                                            @endif
                                        </p>

                                        <p class="text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">{{  __('Emosi: ') }}</span>
                                            <x-emotion-display class="text-gray-500 dark:text-gray-400" :emotion="$counseling->emotion"  />
                                        </p>
                                        @endrole
                                    </td>                                    
                                   
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex items-start space-x-1 text-xs justify-end">
                                            <x-button-link href="{{ route('counselings.show', $counseling) }}" class="uppercase text-xs py-2 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-gray-700 dark:text-gray-300 border border-transparent duration-150 focus:outline-none rounded-lg text-white transition-colors focus:shadow-outline-gray hover:bg-gray-100 dark:hover:bg-gray-700 focus:shadow-outline-gray"> {{ __('Lihat') }} </x-button-link>

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
                                                
                                            @endif
                                            

                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                
            </div>
        </div>

    </div>
    
    <div class="pagination">
        {{ $counselings->links() }}
    </div>
</x-app-layout>



