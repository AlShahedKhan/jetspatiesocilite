@props(['value' => null])
<tr {{ $attributes->merge(['class' => '']) }}>
    {{ $value ?? $slot }}
</tr>
