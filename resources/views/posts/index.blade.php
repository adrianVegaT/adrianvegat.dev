<x-app-layout>
    <x-slot name="title">Blog</x-slot>
    <x-slot name="metaDescription">Artículos y tutoriales sobre desarrollo web, inteligencia artificial, robótica y tecnología</x-slot>

    <!-- Header -->
    <section class="border-b border-gray-200 dark:border-terminal-border">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="flex items-center gap-3 text-3xl font-bold text-gray-900 dark:text-white">
                <span class="font-mono text-primary-600 dark:text-primary-500">#</span> Blog
            </h1>
            <p class="mt-2 text-terminal-muted dark:text-terminal-muted font-mono text-sm">
                Artículos, tutoriales y documentación sobre mis proyectos y aprendizajes
            </p>
        </div>
    </section>

    <!-- Posts List -->
    <section class="py-12 bg-white dark:bg-terminal-bg">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('post-list')
        </div>
    </section>
</x-app-layout>