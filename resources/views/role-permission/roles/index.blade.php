<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div
                    class="mb-6 p-4 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 font-semibold rounded-md shadow-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Right-Aligned Button -->
                <div class="flex justify-end mb-4">
                    @can('role_create')
                        <x-nav-link href="{{ route('roles.create') }}" :active="request()->routeIs('roles.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            {{ __('Add Role') }}
                        </x-nav-link>
                    @endcan
                </div>

                <!-- Main Content - Beautified Table -->
                <div class="mt-6 overflow-x-auto">
                    <x-table>
                        <x-thead>
                            <x-tr>
                                <x-th>ID</x-th>
                                <x-th>Name</x-th>
                                @if (Gate::check('add_role_permissions') || Gate::check('give_role_permissions'))
                                    <x-th>Actions</x-th>
                                @endif
                            </x-tr>
                        </x-thead>
                        <x-tbody>
                            @foreach ($roles as $role)
                                <x-tr>
                                    <x-td>
                                        {{ $role->id }}</x-td>
                                    <x-td>
                                        {{ $role->name }}</x-td>
                                    <x-td>
                                        @can('add_role_permissions||give_role_permissions')
                                            <x-nav-link href="{{ route('roles.add-permissions', $role->id) }}">
                                                {{ __('Add / Edit Role Permissions') }}
                                            </x-nav-link>
                                        @endcan
                                        @can('role_update')
                                            <x-nav-link href="{{ route('roles.edit', $role->id) }}">
                                                {{ __('Edit') }}
                                            </x-nav-link>
                                        @endcan
                                        @can('role_delete')
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-0 m-0 border-0 bg-transparent">
                                                    <x-nav-link>{{ __('Delete') }}</x-nav-link>
                                                </button>
                                            </form>
                                        @endcan
                                    </x-td>
                                </x-tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
