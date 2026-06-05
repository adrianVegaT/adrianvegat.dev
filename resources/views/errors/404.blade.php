<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-terminal-bg px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-primary-600 dark:text-primary-500 font-mono">404</h1>
            </div>

            <div class="mb-6">
                <svg class="mx-auto h-20 w-20 text-terminal-muted dark:text-terminal-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Página no encontrada
                </h2>
                <p class="font-mono text-sm text-terminal-muted dark:text-terminal-dim">
                    Lo sentimos, la página que estás buscando no existe o ha sido movida.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    onclick="window.history.back()"
                    class="inline-flex items-center justify-center px-5 py-2.5 font-mono text-sm no-underline rounded-md text-terminal-muted dark:text-terminal-muted bg-white dark:bg-terminal-card border border-terminal-border dark:border-terminal-border hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors"
                >
                    ← Volver atrás
                </button>
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 font-mono text-sm no-underline rounded-md text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 transition-colors"
                >
                    ~/inicio
                </a>
            </div>

            <div class="mt-8">
                <p class="font-mono text-xs text-terminal-muted dark:text-terminal-dim">
                    Si crees que esto es un error,
                    <a href="mailto:{{ config('mail.from.address') }}" class="text-primary-600 dark:text-primary-500 hover:underline">
                        contáctanos
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>