<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rol: {{ $role->name }} {{ __('bewerken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @method('PATCH')
                        @csrf
                        <x-validation-errors />

                        <div class="grid md:grid-cols-1 sm:grid-cols-1 gap-6">
                            <div class="grid md:grid-rows-1 sm:grid-rows-1 gap-6">
                                <div>
                                    <x-jet-label for="name" :value="__('Naam')" />
                                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $role->name }}" autofocus />
                                </div>
                            </div>
                            <div class="grid grid-rows-1 gap-6">
                                <div>
                                    <x-jet-label for="status" :value="__('Permissions')" />
                                    @foreach ($permission as $value)
                                        <label for="permission-toggle-{{ $value->id }}" class="relative inline-flex items-center mb-4 cursor-pointer">
                                            <input type="checkbox" value="{{ $value->id }}" @checked(in_array($value->id, $rolePermissions)) id="permission-toggle-{{ $value->id }}" name="permission[]" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $value->name }}</span>
                                        </label>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                        @livewire('back-button', ['url' => route('roles.index'), 'name' => 'Terug'])
                        <x-jet-button class="ml-3">
                            {{ __('Aanpassen') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>