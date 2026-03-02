@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-all duration-200 shadow-lg shadow-red-500/50'
            : 'inline-flex items-center px-4 py-2.5 rounded-full text-sm font-medium text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
