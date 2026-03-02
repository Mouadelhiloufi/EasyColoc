@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white/20 bg-black/30 text-white placeholder:text-white/40 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm transition-colors duration-200']) }}>
