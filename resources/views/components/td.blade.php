@props(['value' => null]) {{-- Ensure value is explicitly defined as null by default --}}

<td {{ $attributes->merge(['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center']) }}>
    {{ $value ?? $slot }}
</td>
