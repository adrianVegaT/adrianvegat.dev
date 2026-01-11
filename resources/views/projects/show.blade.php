<x-app-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>
    <x-slot name="metaDescription">{{ $project->summary ?? Str::limit(strip_tags($project->description), 160) }}</x-slot>
    @if($project->image)
    <x-slot name="ogImage">{{ Storage::url($project->image) }}</x-slot>
    @endif

    <!-- Hero Section -->
    <section class="relative bg-white dark:bg-gray-950 overflow-hidden">
        @if($project->image)
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover opacity-10 dark:opacity-5">
            <div class="absolute inset-0 bg-gradient-to-b from-white/50 to-white dark:from-gray-950/50 dark:to-gray-950"></div>
        </div>
        @endif

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                            Inicio
                        </a>
                    </li>
                    <li class="text-gray-400 dark:text-gray-600">/</li>
                    <li>
                        <a href="{{ route('projects.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                            Proyectos
                        </a>
                    </li>
                    <li class="text-gray-400 dark:text-gray-600">/</li>
                    <li class="text-gray-900 dark:text-white font-medium">{{ $project->title }}</li>
                </ol>
            </nav>

            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($project->categories as $category)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-primary-400 border border-primary-200 dark:border-primary-800">
                    {{ $category->name }}
                </span>
                @endforeach
            </div>

            <!-- Title -->
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                {{ $project->title }}
            </h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-8">
                <div class="flex items-center space-x-2">
                    <img src="{{ $project->user->avatar_url }}" alt="{{ $project->user->name }}" class="w-8 h-8 rounded-full">
                    <span>{{ $project->user->name }}</span>
                </div>
                <span>·</span>
                <time datetime="{{ $project->published_at->toISOString() }}">
                    {{ $project->published_at->format('d M Y') }}
                </time>
                @if($project->posts_count > 0)
                <span>·</span>
                <span>{{ $project->posts_count }} {{ Str::plural('entrada', $project->posts_count) }}</span>
                @endif
            </div>

            <!-- Links -->
            <div class="flex flex-wrap gap-4">
                @if($project->demo_url)
                <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center px-6 py-3 text-base font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Ver demo
                </a>
                @endif
                @if($project->repository_url)
                <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center px-6 py-3 text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                    Repositorio
                </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Project Image -->
    @if($project->image)
    <section class="py-8 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl overflow-hidden shadow-xl">
                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full">
            </div>
        </div>
    </section>
    @endif

    <!-- Project Description -->
    <section class="py-12 bg-white dark:bg-gray-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg dark:prose-invert max-w-none">
                {!! nl2br(e($project->description)) !!}
            </div>
        </div>
    </section>

    <!-- Project Posts -->
    @if($project->posts->count() > 0)
    <section class="py-12 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-8">
                Entradas del proyecto
            </h2>

            <div class="space-y-6">
                @foreach($project->posts as $post)
                <article class="group bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 overflow-hidden">
                    <a href="{{ route('posts.show', $post->slug) }}" class="flex flex-col sm:flex-row">
                        @if($post->featured_image)
                        <div class="sm:w-64 aspect-video sm:aspect-auto overflow-hidden bg-gray-100 dark:bg-gray-800 flex-shrink-0">
                            <img src="{{ Storage::url($post->featured_image) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @endif

                        <div class="p-6 flex-1">
                            <div class="flex items-center gap-3 mb-3 text-sm text-gray-500 dark:text-gray-400">
                                <time datetime="{{ $post->published_at->toISOString() }}">
                                    {{ $post->published_at->format('d M Y') }}
                                </time>
                                @if($post->reading_time)
                                <span>·</span>
                                <span>{{ $post->reading_time }} min lectura</span>
                                @endif
                            </div>

                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors">
                                {{ $post->title }}
                            </h3>

                            @if($post->excerpt)
                            <p class="text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $post->excerpt }}
                            </p>
                            @endif
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Related Projects -->
    <section class="py-12 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-8">
                Proyectos relacionados
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                // Obtener proyectos relacionados por categorías
                $relatedProjects = \App\Models\Project::whereHas('categories', function($query) use ($project) {
                $query->whereIn('categories.id', $project->categories->pluck('id'));
                })
                ->where('id', '!=', $project->id)
                ->published()
                ->limit(3)
                ->get();
                @endphp

                @forelse($relatedProjects as $relatedProject)
                <a href="{{ route('projects.show', $relatedProject->slug) }}"
                    class="group bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 overflow-hidden">
                    @if($relatedProject->image)
                    <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800">
                        <img src="{{ Storage::url($relatedProject->image) }}"
                            alt="{{ $relatedProject->title }}"
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
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors line-clamp-2">
                            {{ $relatedProject->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                            {{ $relatedProject->summary ?? Str::limit($relatedProject->description, 100) }}
                        </p>
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">
                    No hay proyectos relacionados disponibles
                </p>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>