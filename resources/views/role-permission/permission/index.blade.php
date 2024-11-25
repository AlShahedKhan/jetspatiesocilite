<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
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
                    <x-nav-link href="{{ route('permissions.create') }}" :active="request()->routeIs('permissions.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        {{ __('Add Permission') }}
                    </x-nav-link>
                </div>

                <!-- Main Content - Beautified Table -->
                <div class="mt-6 overflow-x-auto">


                    <x-table>
                        <x-thead>
                            <x-tr>
                                <x-th>ID</x-th>
                                <x-th>Name</x-th>
                                <x-th>Actions</x-th>
                            </x-tr>
                        </x-thead>
                        <x-tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($permissions as $permission)
                                <x-tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <x-td class="py-4 px-6 text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $permission->id }}</x-td>
                                    <x-td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $permission->name }}</x-td>
                                    <x-td class="py-4 px-6 text-sm">
                                        <x-nav-link href="{{ route('permissions.edit', $permission->id) }}">
                                            {{ __('Edit') }}
                                        </x-nav-link>

                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-0 m-0 border-0 bg-transparent">
                                                <x-nav-link>{{ __('Delete') }}</x-nav-link>
                                            </button>
                                        </form>
                                    </x-td>
                                </x-tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                    {{-- <table class="w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">ID</th>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">Name</th>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($permissions as $permission)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $permission->id }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $permission->name }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        <x-nav-link href="{{ route('permissions.edit', $permission->id) }}">
                                            {{ __('Edit') }}
                                        </x-nav-link>

                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-0 m-0 border-0 bg-transparent">
                                                <x-nav-link>{{ __('Delete') }}</x-nav-link>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
