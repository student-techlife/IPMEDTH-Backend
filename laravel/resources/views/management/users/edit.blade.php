<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gebruiker: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @method('PATCH')
                        @csrf
                        <x-validation-errors />

                        <div class="grid gap-6 mb-6 lg:grid-cols-2">
                            <div>
                                <x-jet-label for="name" :value="__('Naam')" />
                                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" autofocus />
                            </div>
                            <div>
                                <x-jet-label for="email" :value="__('E-Mail')" />
                                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}" autofocus />
                            </div>
                            <div>
                                <x-jet-label for="password" :value="__('Wachtwoord')" />
                                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" autofocus />
                            </div>
                            <div>
                                <x-jet-label for="confirm-password" :value="__('Bevestig wachtwoord')" />
                                <x-jet-input id="confirm-password" class="block mt-1 w-full" type="password" name="confirm-password" autofocus />
                            </div>
                            <div class="grid grid-rows-2 gap-6">
                                <div>
                                    <x-jet-label for="roles" :value="__('Rol')" />
                                    <select id="roles" name="roles[]" autofocus class="border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full mt-1 p-2.5">
                                        @foreach ($roles as $key => $role)
                                            <option value="{{ $role }}" @selected($user->getRoleNames()->contains($role))>{{ __($role) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                        @livewire('back-button', ['url' => route('users.index'), 'name' => 'Terug'])
                        <x-jet-button class="ml-3">
                            {{ __('Aanpassen') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>