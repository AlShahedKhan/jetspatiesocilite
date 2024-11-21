<x-form-section submit="createPermission">
    <x-slot name="title">
        {{ __('Permission Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new permission to allow a team member to perform an action.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-label value="{{ __('Permission') }}" />

            <div class="flex items-center mt-2">
                <div class="ms-4 leading-tight">
                    <div class="text-gray-900 dark:text-white">{{ $this->user->name }}</div>
                    <div class="text-gray-700 dark:text-gray-300 text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Team Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Create') }}
        </x-button>
    </x-slot>
</x-form-section>
