<x-app-layout>
    <x-slot name="title">Proyectos</x-slot>
    <x-slot name="metaDescription">Explora mis proyectos de desarrollo web, inteligencia artificial y robótica</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-700 dark:to-primary-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                Proyectos
            </h1>
            <p class="text-lg sm:text-xl text-primary-50 dark:text-primary-100 max-w-2xl mx-auto">
                Explora mis proyectos de desarrollo web, inteligencia artificial, robótica y más
            </p>
        </div>
    </section>

    <!-- Projects List -->
    <section class="py-12 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('project-list')
        </div>
    </section>
</x-app-layout>