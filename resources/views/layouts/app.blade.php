<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'Adrian Vega') }}</title>

    <!-- SEO Meta Tags -->
    @if(isset($metaDescription))
    <meta name="description" content="{{ $metaDescription }}">
    @else
    <meta name="description" content="Portafolio de desarrollo web, IA y robótica de Adrian Vega">
    @endif

    @if(isset($metaKeywords))
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ isset($title) ? $title : 'Adrian Vega - Developer Portfolio' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Portafolio de desarrollo web, IA y robótica' }}">
    @if(isset($ogImage))
    <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ isset($title) ? $title : 'Adrian Vega - Developer Portfolio' }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? 'Portafolio de desarrollo web, IA y robótica' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Theme Script - Debe cargarse antes que todo para evitar flash -->
    <script>
        // Función para inicializar el tema
        function initTheme() {
            const theme = localStorage.getItem('theme') || 'dark'; // Por defecto oscuro
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        // Ejecutar inmediatamente
        initTheme();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-white dark:bg-terminal-bg text-gray-900 dark:text-gray-100 terminal-scanlines" x-data="{ theme: localStorage.getItem('theme') || 'dark', mobileMenuOpen: false }">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 bg-white/95 dark:bg-terminal-bg/95 backdrop-blur-md border-b border-gray-200 dark:border-terminal-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 text-primary-600 dark:text-primary-500 font-mono text-sm font-semibold no-underline">
                            <span class="text-gray-400 dark:text-terminal-dim">~$</span> adrian_vega<span class="cursor-blink dark-cursor"></span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:gap-0 font-mono text-xs">
                        <a href="{{ route('home') }}" class="px-4 py-2 no-underline border-b-2 transition-colors {{ request()->routeIs('home') ? 'text-primary-600 dark:text-primary-500 border-primary-600 dark:border-primary-500' : 'text-terminal-muted dark:text-terminal-muted border-transparent hover:text-primary-600 dark:hover:text-primary-500 hover:bg-primary-50/50 dark:hover:bg-primary-500/10' }}">
                            ~/inicio
                        </a>
                        <span class="text-gray-300 dark:text-terminal-dim select-none">|</span>
                        <a href="{{ route('projects.index') }}" class="px-4 py-2 no-underline border-b-2 transition-colors {{ request()->routeIs('projects.*') ? 'text-primary-600 dark:text-primary-500 border-primary-600 dark:border-primary-500' : 'text-terminal-muted dark:text-terminal-muted border-transparent hover:text-primary-600 dark:hover:text-primary-500 hover:bg-primary-50/50 dark:hover:bg-primary-500/10' }}">
                            ~/proyectos
                        </a>
                        <span class="text-gray-300 dark:text-terminal-dim select-none">|</span>
                        <a href="{{ route('posts.index') }}" class="px-4 py-2 no-underline border-b-2 transition-colors {{ request()->routeIs('posts.*') ? 'text-primary-600 dark:text-primary-500 border-primary-600 dark:border-primary-500' : 'text-terminal-muted dark:text-terminal-muted border-transparent hover:text-primary-600 dark:hover:text-primary-500 hover:bg-primary-50/50 dark:hover:bg-primary-500/10' }}">
                            ~/blog
                        </a>

                        <!-- Theme Switcher -->
                        <!-- <button
                            @click="
                                theme = theme === 'dark' ? 'light' : 'dark';
                                localStorage.setItem('theme', theme);
                                if (theme === 'dark') {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                            "
                            class="ml-4 px-3 py-1.5 text-xs font-mono rounded border transition-colors bg-transparent text-terminal-muted dark:text-terminal-muted border-terminal-border dark:border-terminal-border hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500"
                            title="Cambiar tema">
                            <span x-show="theme === 'dark'">theme:dark</span>
                            <span x-show="theme === 'light'" style="display:none;">theme:light</span>
                        </button> -->

                        @auth
                        @role('admin|author')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500 font-mono text-xs transition-colors">
                            ~/admin
                        </a>
                        @endrole

                        @php
                            $nameParts = explode(' ', auth()->user()->name);
                            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                        @endphp
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 font-mono text-xs text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500 transition-colors">
                                @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-6 h-6 rounded object-cover">
                                @else
                                <div class="w-6 h-6 rounded bg-primary-600 flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ $initials }}
                                </div>
                                @endif
                            </button>

                            <div x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-terminal-card rounded-lg shadow-lg border border-gray-200 dark:border-terminal-border py-1"
                                style="display: none;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 font-mono text-xs text-terminal-muted dark:text-terminal-muted hover:bg-gray-100 dark:hover:bg-terminal-elevated">
                                        logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center gap-2">
                        <!-- <button
                            @click="
                                theme = theme === 'dark' ? 'light' : 'dark';
                                localStorage.setItem('theme', theme);
                                if (theme === 'dark') {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                            "
                            class="px-2 py-1 text-xs font-mono rounded border transition-colors bg-transparent text-terminal-muted dark:text-terminal-muted border-terminal-border dark:border-terminal-border hover:border-primary-500 dark:hover:border-primary-500">
                            <span x-show="theme === 'dark'">dark</span>
                            <span x-show="theme === 'light'" style="display:none;">light</span>
                        </button> -->

                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="md:hidden border-t border-gray-200 dark:border-terminal-border font-mono">
                <div class="px-4 py-3 space-y-3">
                    <a href="{{ route('home') }}" class="block text-xs no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">
                        ~/inicio
                    </a>
                    <a href="{{ route('projects.index') }}" class="block text-xs no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">
                        ~/proyectos
                    </a>
                    <a href="{{ route('posts.index') }}" class="block text-xs no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">
                        ~/blog
                    </a>

                    @auth
                    @role('admin|author')
                    <a href="{{ route('admin.dashboard') }}" class="block text-xs no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">
                        ~/admin
                    </a>
                    @endrole
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left text-xs no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">
                            logout
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200 dark:border-terminal-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="font-mono text-xs text-terminal-dim dark:text-terminal-dim">
                        <span class="text-primary-600 dark:text-primary-500">~$</span> echo "&copy; {{ date('Y') }} Adrian Vega"
                    </div>
                    <ul class="flex gap-6 font-mono text-xs">
                        <li><a href="{{ route('projects.index') }}" class="no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">~/proyectos</a></li>
                        <li><a href="{{ route('posts.index') }}" class="no-underline text-terminal-muted dark:text-terminal-muted hover:text-primary-600 dark:hover:text-primary-500">~/blog</a></li>
                    </ul>
                    <div class="flex gap-2">
                        <a href="https://github.com/adrianVegaT" class="w-8 h-8 flex items-center justify-center rounded border transition-colors bg-gray-50 dark:bg-terminal-card border-gray-200 dark:border-terminal-border text-terminal-muted dark:text-terminal-muted hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/adrian-antonio-vega-torres-1b3284166/" class="w-8 h-8 flex items-center justify-center rounded border transition-colors bg-gray-50 dark:bg-terminal-card border-gray-200 dark:border-terminal-border text-terminal-muted dark:text-terminal-muted hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://x.com/adrianvegat" class="w-8 h-8 flex items-center justify-center rounded border transition-colors bg-gray-50 dark:bg-terminal-card border-gray-200 dark:border-terminal-border text-terminal-muted dark:text-terminal-muted hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>

</html>