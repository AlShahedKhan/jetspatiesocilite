<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
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
                    <x-nav-link href="{{ route('users.create') }}" :active="request()->routeIs('users.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        {{ __('Add User') }}
                    </x-nav-link>
                </div>

                <!-- Main Content - Beautified Table -->
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">ID</th>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">Name</th>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">Email</th>
                                <th class="py-4 px-6 text-left text-sm font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $user->id }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $user->name }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $user->email }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach ($user->getRoleNames() as $rolename)
                                            <x-label
                                                class="bg-green-500 text-color-blue-900 ">{{ $rolename }}</x-label>
                                        @endforeach
                                    </td>



                                    <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">
                                        <x-nav-link href="{{ route('users.edit', $user->id) }}">
                                            {{ __('Edit') }}
                                        </x-nav-link>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="inline-block">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
