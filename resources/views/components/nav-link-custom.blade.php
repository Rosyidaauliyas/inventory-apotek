@props(['active', 'icon'])

@php
// Logika untuk menentukan gaya tombol saat aktif atau tidak
$classes = ($active ?? false)
            ? 'flex items-center gap-4 py-3.5 px-6 rounded-2xl bg-white/10 text-white shadow-xl shadow-blue-900/20 font-bold border-l-4 border-white transition-all duration-300'
            : 'flex items-center gap-4 py-3.5 px-6 rounded-2xl text-blue-100 hover:bg-white/5 hover:text-white transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="fas {{ $icon }} w-5 text-center text-sm {{ ($active ?? false) ? 'opacity-100' : 'opacity-50' }}"></i>
    
    <span class="text-[13px] tracking-wide">{{ $slot }}</span>
</a>