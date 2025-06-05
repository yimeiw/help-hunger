@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs text-creamhh']) }}>
    {{ $value ?? $slot }}
</label>
