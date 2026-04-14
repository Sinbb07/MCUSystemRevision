@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium mt-2 max-sm:text-sm text-primary']) }}>
    {{ $value ?? $slot }}
</label>