<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Right-Aligned Button -->
                <div class="flex justify-end">
                    <x-nav-link href="{{ route('permissions.index') }}" :active="request()->routeIs('permissions.index')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                        style="visibility: visible;">
                        {{ __('Back') }}
                    </x-nav-link>
                </div>

                <!-- Main Content -->
                <div class="mt-6">
                    <form action="{{ route('permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Add this directive to specify the HTTP method -->
                        <div>
                            <x-label for="name" value="{{ __('Permission Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ old('name', $permission->name) }}" required autofocus autocomplete="name" />
                        </div>
                        @can('permission_update')
                            <x-button class="mt-4">
                                {{ __('Update') }}
                            </x-button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
