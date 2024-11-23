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
                <div class="flex justify-end">
                    <h4
                        class="text-lg font-medium text-gray-800 dark:text-gray-200 mr-4 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-md shadow">
                        Role: {{ $role->name }}
                    </h4>

                    <x-nav-link href="{{ route('roles.index') }}" :active="request()->routeIs('roles.index')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                        style="visibility: visible;">
                        {{ __('Back') }}
                    </x-nav-link>
                </div>

                <!-- Main Content -->
                <div class="mt-6">
                    <form action="{{ route('roles.add-permissions', $role) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Add this directive to specify the HTTP method -->
                        @error('permission')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                        <div>
                            @foreach ($permission as $perm)
                                <label>
                                    <input type="checkbox" name="permission[]" value="{{ $perm->name }}"
                                        {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $perm->name }}
                                </label>
                            @endforeach
                            <x-label for="name" value="{{ __('Role Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ old('name', $role->name) }}" required autofocus autocomplete="name" />
                        </div>
                        <x-button class="mt-4">
                            {{ __('Update') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
