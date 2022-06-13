<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            @can('role-create')
                <a href="{{ route('roles.create') }}" class="text-rf-green hover:text-white border border-rf-green hover:bg-rf-dark-green focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 text-center">{{ __('New role') }}</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-success-message />
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $role->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $role->name }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{-- <a href="{{ route('roles.show', $role->id) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">{{ __('Bekijken') }}</a> --}}
                                @can('role-edit')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">{{ __('Edit') }}</a>
                                @endcan
                                <form class="inline-block" action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @method('DELETE')
                                    @csrf
                                    @can('role-delete')
                                        <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="{{ __('Remove') }}">
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>