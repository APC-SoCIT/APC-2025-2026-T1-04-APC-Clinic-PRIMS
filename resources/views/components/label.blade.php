@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-prims-azure-900']) }}>
    {{ $value ?? $slot }}
</label>
