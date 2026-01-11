@props(['size' => 'default', 'gradient' => true])

@php
    $sizes = [
        'xs' => 'w-6 h-6',
        'sm' => 'w-8 h-8',
        'default' => 'w-10 h-10',
        'lg' => 'w-16 h-16',
        'xl' => 'w-24 h-24',
        '2xl' => 'w-32 h-32',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div {{ $attributes->merge(['class' => $sizeClass . ' flex items-center justify-center']) }}>
    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
        @if($gradient)
            <defs>
                <linearGradient id="logo-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#8B5CF6;stop-opacity:1" />
                </linearGradient>
            </defs>
        @endif
        
        <!-- Hexágono de fondo -->
        <path d="M50 5 L90 27.5 L90 72.5 L50 95 L10 72.5 L10 27.5 Z" 
              fill="@if($gradient) url(#logo-gradient) @else currentColor @endif" 
              opacity="0.1"/>
        
        <!-- Letra A -->
        <path d="M30 70 L40 40 L50 70 M35 60 L45 60" 
              stroke="@if($gradient) url(#logo-gradient) @else currentColor @endif" 
              stroke-width="6" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              fill="none"/>
        
        <!-- Letra V -->
        <path d="M55 40 L62.5 70 L70 40" 
              stroke="@if($gradient) url(#logo-gradient) @else currentColor @endif" 
              stroke-width="6" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              fill="none"/>
    </svg>
</div>