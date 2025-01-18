<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Heading (h4) with matching design -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Heading (h4) with a matching color design -->
            <x-h4>{{ __('Users Table') }}</x-h4>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-welcome /> --}}
                @if (hasPermission('user_read'))
                    <x-table>
                        <x-thead>
                            <x-tr>
                                <x-th>{{ __('ID') }}</x-th>
                                <x-th>{{ __('Name') }}</x-th>
                                <x-th>{{ __('Email') }}</x-th>
                                <x-th>{{ __('Role') }}</x-th>
                            </x-tr>
                        </x-thead>
                        <x-tbody>
                            @foreach ($users as $user)
                                <x-tr>
                                    <x-td>{{ $user->id }}</x-td>
                                    <x-td>{{ $user->name }}</x-td>
                                    <x-td>{{ $user->email }}</x-td>
                                    <x-td>
                                        @foreach ($user->getRoleNames() as $role)
                                            {{ $role }}
                                        @endforeach
                                    </x-td>
                                </x-tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                @endif
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-h4>{{ __('Roles Table') }}</x-h4>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @if (hasPermission('role_read'))
                    <x-table>
                        <x-thead>
                            <x-tr>
                                <x-th>{{ __('ID') }}</x-th>
                                <x-th>{{ __('Name') }}</x-th>
                            </x-tr>
                        </x-thead>
                        <x-tbody>
                            @foreach ($roles as $role)
                                <x-tr>
                                    <x-td>{{ $role->id }}</x-td>
                                    <x-td>{{ $role->name }}</x-td>
                                </x-tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                @endif
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-h4>{{ __('Permissions Table') }}</x-h4>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @if (hasPermission('permission_read'))
                    <x-table>
                        <x-thead>
                            <x-tr>
                                <x-th>{{ __('ID') }}</x-th>
                                <x-th>{{ __('Name') }}</x-th>
                            </x-tr>
                        </x-thead>
                        <x-tbody>
                            @foreach ($permissions as $permission)
                                <x-tr>
                                    <x-td>{{ $permission->id }}</x-td>
                                    <x-td>{{ $permission->name }}</x-td>
                                </x-tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
