@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-4 pe-4 py-3 text-start text-base font-semibold text-white bg-red-600/20 border-l-4 border-red-600 focus:outline-none transition duration-200'
            : 'block w-full ps-4 pe-4 py-3 text-start text-base font-medium text-white/70 hover:text-white hover:bg-white/5 border-l-4 border-transparent hover:border-white/20 focus:outline-none transition duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
