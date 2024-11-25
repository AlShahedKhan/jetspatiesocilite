@props(['value' => null]) {{-- Ensure value is explicitly defined as null by default --}}
<thead {{ $attributes->merge(['class' => 'bg-blue-600 text-white']) }}>
    {{ $value ?? $slot }}
</thead>
