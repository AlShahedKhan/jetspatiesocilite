@props(['value' => null])

<th
    {{ $attributes->merge(['class' => 'bg-gradient-to-r from-blue-500 to-indigo-500 text-black']) }}> {{-- Add w-full for full-width adaptability --}}
    {{ $value ?? $slot }}
</th>
