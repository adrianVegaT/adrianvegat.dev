<x-app-layout>
    <x-slot name="title">Proyectos</x-slot>
    <x-slot name="metaDescription">Explora mis proyectos de desarrollo web, inteligencia artificial y robótica</x-slot>

    <!-- Header -->
    <section class="border-b border-gray-200 dark:border-terminal-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="flex items-center gap-3 text-3xl font-bold text-gray-900 dark:text-white">
                <span class="font-mono text-primary-600 dark:text-primary-500">#</span> Proyectos
            </h1>
            <p class="mt-2 text-terminal-muted dark:text-terminal-muted font-mono text-sm">
                Explora mis proyectos de desarrollo web, inteligencia artificial, robótica y más
            </p>
        </div>
    </section>

    <!-- Projects List -->
    <section class="py-12 bg-white dark:bg-terminal-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('project-list')
        </div>
    </section>
</x-app-layout>