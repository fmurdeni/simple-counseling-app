<x-app-layout>
    <div class="container grid px-6 mx-auto">
    
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Peran Pengguna') }}
        </h2>
        
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            @role(1)
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="w-full overflow-x-auto">
                    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">{{ __('Tambah Peran') }}</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Tambah peran pengguna dengan mengisi form berikut.</p>
                    <form method="post" action="{{ route('roles.store') }}" class="flex items-center gap-4">
                        @csrf
                        
                        <div class="mb-4 flex-1">
                            <x-input-text id="role_name" name="name" type="text" class="w-full" required autofocus autocomplete="role" placeholder="Masukkan nama peran" />
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>
                        <div class="mb-4">
                            <x-primary-button>
                                {{ __('Tambah') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @endrole

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="w-full overflow-x-auto">
                    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">{{ __('Daftar Peran') }}</h4>
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">{{ __('Nama') }}</th>
                                @role(1)
                                <th class="px-4 py-3 text-center">{{ __('Aksi') }}</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800">

                            @foreach ($roles as $role)
                                <tr class="text-gray-700 dark:text-gray-400 role-{{ $role->id }}">
                                    <td class="px-4 py-3 text-sm">
                                        <div class="display-role-name text-gray-500 dark:text-gray-400">
                                        {{ $role->name }}
                                        </div>
                                        
                                        <form method="post" action="{{ route('roles.update', $role->id) }}" class="edit-role inline flex items-center relative hidden">
                                            @csrf
                                            @method('PUT')
                                            <x-input-text id="role_name" name="name" type="text" class="py-1 text-sm text-gray-500 dark:text-gray-400" :value="old('name', $role->name)" required autofocus autocomplete="role" />
                                            <x-secondary-button type="submit" class="uppercase text-xs">{{ __('Simpan') }}</x-secondary-button>
                                        </form>
                                        
                                    </td>
                                    @role(1)
                                    <td class="px-4 py-3 text-sm w-px">
                                        <div class="flex items-center space-x-1 text-sm justify-end">
                                            <button class="p-2 button-edit-role inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700" data-id="{{ $role->id }}"><x-icon-edit/></button>
                                            <form id="delete_user" class="delete-form" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="p-2 button-delete-role inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700"><x-icon-trash/></button>
                                            </form>
                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

