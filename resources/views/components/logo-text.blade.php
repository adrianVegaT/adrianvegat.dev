@props(['size' => 'default'])

@php
    $sizes = [
        'sm' => 'text-lg',
        'default' => 'text-2xl',
        'lg' => 'text-3xl',
        'xl' => 'text-4xl',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <x-logo :size="$size === 'sm' ? 'sm' : ($size === 'lg' ? 'lg' : 'default')" />
    <div class="flex flex-col">
        <span class="{{ $sizeClass }} font-bold bg-gradient-to-r from-primary-600 to-violet-600 bg-clip-text text-transparent">
            Adrian Vega
        </span>
        <span class="text-xs text-gray-600 dark:text-gray-400 -mt-1">
            Full Stack Developer
        </span>
    </div>
</div>