@props(['size' => 'default'])

@php
    $sizes = [
        'sm' => 'text-sm',
        'default' => 'text-lg',
        'lg' => 'text-xl',
        'xl' => 'text-2xl',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-2 font-mono']) }}>
    <span class="text-gray-400 dark:text-terminal-dim">~$</span>
    <span class="{{ $sizeClass }} font-semibold text-primary-600 dark:text-primary-500">
        adrian_vega
    </span>
    <span class="cursor-blink dark-cursor {{ $size === 'sm' ? 'h-4' : '' }}"></span>
</div>