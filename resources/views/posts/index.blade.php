<x-app-layout>
    <x-slot name="title">Blog</x-slot>
    <x-slot name="metaDescription">Artículos y tutoriales sobre desarrollo web, inteligencia artificial, robótica y tecnología</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-700 dark:to-primary-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                Blog
            </h1>
            <p class="text-lg sm:text-xl text-primary-50 dark:text-primary-100 max-w-2xl mx-auto">
                Artículos, tutoriales y documentación sobre mis proyectos y aprendizajes
            </p>
        </div>
    </section>

    <!-- Posts List -->
    <section class="py-12 bg-white dark:bg-gray-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('post-list')
        </div>
    </section>
</x-app-layout>