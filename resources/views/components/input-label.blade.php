@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-white/90']) }}>
    {{ $value ?? $slot }}
</label>
