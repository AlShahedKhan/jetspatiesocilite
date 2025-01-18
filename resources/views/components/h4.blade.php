@props(['value' => null])

<h4 {{ $attributes->merge(['class' => 'text-lg font-medium text-white px-4 py-2 bg-blue-700 dark:bg-blue-800 rounded-md shadow-md mb-4']) }}>
    {{ $value ?? $slot }}
</h4>
