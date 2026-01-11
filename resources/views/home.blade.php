<x-app-layout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-white dark:bg-gray-950">
        <!-- Decorative Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/5 dark:bg-primary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-slate-500/5 dark:bg-slate-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 lg:py-32">
            <div class="max-w-3xl">
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-primary-400 border border-primary-200 dark:border-primary-800">
                        Full Stack Developer
                    </span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Hola, soy
                    <span class="text-primary-600 dark:text-primary-500">Adrian Vega</span>
                </h1>

                <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    Desarrollo soluciones tecnológicas innovadoras enfocadas en desarrollo web, inteligencia artificial y robótica.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('projects.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 transition-colors duration-200 shadow-sm">
                        Ver proyectos
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="{{ route('posts.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                        Leer blog
                    </a>
                </div>

                <!-- Tech Stack -->
                <div class="mt-16 pt-8 border-t border-gray-200 dark:border-gray-800">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">Stack tecnológico</p>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800">Laravel</span>
                        <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800">Vue.js</span>
                        <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800">Python</span>
                        <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800">TensorFlow</span>
                        <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800">Arduino</span>
                        <span class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-800">Docker</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    @if($featuredProjects->count() > 0)
    <section class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    Proyectos destacados
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Explora algunos de mis proyectos más recientes
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}"
                    class="group bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 overflow-hidden">
                    @if($project->image)
                    <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800">
                        <img src="{{ Storage::url($project->image) }}"
                            alt="{{ $project->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-primary-500/10 to-slate-500/10 dark:from-primary-500/20 dark:to-slate-500/20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary-500/30 dark:text-primary-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($project->categories as $category)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>

                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors">
                            {{ $project->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                            {{ $project->summary ?? Str::limit($project->description, 100) }}
                        </p>

                        <div class="mt-4 flex items-center text-sm text-primary-600 dark:text-primary-500 font-medium">
                            Ver detalles
                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            @if($projects->count() > 0)
            <div class="text-center mt-10">
                <a href="{{ route('projects.index') }}"
                    class="inline-flex items-center px-6 py-3 text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                    Ver todos los proyectos
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Recent Posts -->
    @if($recentPosts->count() > 0)
    <section class="py-16 sm:py-24 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                        Últimas entradas
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        Artículos y tutoriales sobre desarrollo y tecnología
                    </p>
                </div>
                <a href="{{ route('posts.index') }}"
                    class="hidden sm:inline-flex items-center text-primary-600 dark:text-primary-500 hover:text-primary-700 dark:hover:text-primary-400 font-medium transition-colors">
                    Ver todo
                    <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentPosts as $post)
                <article class="group">
                    <a href="{{ route('posts.show', $post->slug) }}"
                        class="block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 overflow-hidden h-full">
                        @if($post->featured_image)
                        <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800">
                            <img src="{{ Storage::url($post->featured_image) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @endif

                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3 text-sm text-gray-500 dark:text-gray-400">
                                <time datetime="{{ $post->published_at->toISOString() }}">
                                    {{ $post->published_at->format('d M Y') }}
                                </time>
                                @if($post->reading_time)
                                <span>·</span>
                                <span>{{ $post->reading_time }} min</span>
                                @endif
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h3>

                            @if($post->excerpt)
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                {{ $post->excerpt }}
                            </p>
                            @endif

                            <div class="flex flex-wrap gap-2">
                                @foreach($post->categories->take(2) as $category)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    {{ $category->name }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="text-center mt-10 sm:hidden">
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center text-primary-600 dark:text-primary-500 hover:text-primary-700 dark:hover:text-primary-400 font-medium transition-colors">
                    Ver todas las entradas
                    <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 sm:py-20 bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-700 dark:to-primary-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                ¿Tienes un proyecto en mente?
            </h2>
            <p class="text-lg sm:text-xl text-primary-50 dark:text-primary-100 mb-8">
                Estoy disponible para nuevos proyectos y colaboraciones
            </p>
            <a href="mailto:tu-email@ejemplo.com"
                class="inline-flex items-center px-6 py-3 text-base font-medium rounded-lg text-primary-700 dark:text-primary-600 bg-white hover:bg-primary-50 transition-colors duration-200 shadow-sm">
                Contáctame
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </a>
        </div>
    </section>
</x-app-layout>