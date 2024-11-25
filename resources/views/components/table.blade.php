@props(['value' => null]) {{-- Ensure value is explicitly defined as null by default --}}

<div class="w-full overflow-x-auto"> {{-- Make parent container full width and allow horizontal scrolling --}}
    <table {{ $attributes->merge(['class' => 'w-full border-collapse border border-gray-200 rounded-lg shadow-lg overflow-hidden']) }}>
    {{-- <table {{ $attributes->merge(['class' => 'min-w-full border-collapse border border-gray-200 rounded-lg shadow-lg overflow-hidden']) }}> --}}
    {{ $value ?? $slot }}
    </table>
</div>
