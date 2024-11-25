@props(['value' => null])
<tbody {{ $attributes->class="bg-white divide-y divide-gray-200"}}>
    {{ $value ?? $slot}}
</tbody>
