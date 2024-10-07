<x-app-layout>
    <div class="container grid px-6 mx-auto">
    
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Pengguna') }}
        </h2>
       

        <div class="mt-4 flex items-center justify-between mb-6">
            <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                {{ __('Daftar Pengguna') }}
            </h4>
            <x-button-link-primary href="{{ route('users.create') }}">{{ __('Tambah Pengguna') }}</x-button-link>        
        </div>
        

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">{{ __('Nama') }}</th>
                            <th class="px-4 py-3">{{ __('Email') }}</th>
                            <th class="px-4 py-3">{{ __('Peran') }}</th>
                            <th class="px-4 py-3">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:bg-gray-800">
                        @foreach ($users as $user)
                            <tr class="text-gray-700 dark:text-gray-400 text-sm">
                                <td class="px-4 py-3 text-gray-800">
                                    <a href="{{ route('users.edit', $user) }}" class="font-semibold text-sm font-medium text-blue-500 dark:text-blue-400 hover:underline">
                                    {{ $user->name }}</a>
                                   
                                </td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    @if ($user->role === 1)
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"> {{ __('Konselor') }} </span>
                                    @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> {{ __('Mahasiswa') }} </span>
                                    @endif
                                   
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('users.edit', $user) }}" class="text-sm font-medium text-blue-500 dark:text-blue-400 hover:underline">Edit</a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-app-layout>

