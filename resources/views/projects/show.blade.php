<x-app-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>
    <x-slot name="metaDescription">{{ $project->summary ?? Str::limit(strip_tags($project->description), 160) }}</x-slot>
    @if($project->image)
    <x-slot name="ogImage">{{ Storage::url($project->image) }}</x-slot>
    @endif

    <!-- Hero Section -->
    <section class="relative bg-white dark:bg-terminal-bg overflow-hidden border-b border-gray-200 dark:border-terminal-border">
        @if($project->image)
        <div class="absolute inset-0 z-0">
            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover opacity-[0.04] dark:opacity-[0.06]">
            <div class="absolute inset-0 bg-gradient-to-b from-white to-white dark:from-terminal-bg dark:to-terminal-bg"></div>
        </div>
        @endif

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center gap-2 font-mono text-[11px]">
                    <li>
                        <a href="{{ route('home') }}" class="no-underline text-terminal-dim dark:text-terminal-dim hover:text-primary-600 dark:hover:text-primary-500">
                            ~/inicio
                        </a>
                    </li>
                    <li class="text-terminal-dim dark:text-terminal-dim">/</li>
                    <li>
                        <a href="{{ route('projects.index') }}" class="no-underline text-terminal-dim dark:text-terminal-dim hover:text-primary-600 dark:hover:text-primary-500">
                            proyectos
                        </a>
                    </li>
                    <li class="text-terminal-dim dark:text-terminal-dim">/</li>
                    <li class="text-gray-900 dark:text-white font-medium">{{ $project->title }}</li>
                </ol>
            </nav>

            <!-- Categories -->
            <div class="flex flex-wrap gap-1.5 mb-5">
                @foreach($project->categories as $category)
                <span class="px-2 py-0.5 font-mono text-[10px] rounded font-medium bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-400">
                    {{ $category->name }}
                </span>
                @endforeach
            </div>

            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                {{ $project->title }}
            </h1>

            <!-- Meta -->
            <div class="flex flex-wrap items-center gap-3 font-mono text-[11px] text-terminal-dim dark:text-terminal-dim mb-6">
                <div class="flex items-center gap-2">
                    <img src="{{ $project->user->avatar_url }}" alt="{{ $project->user->name }}" class="w-6 h-6 rounded">
                    <span>{{ $project->user->name }}</span>
                </div>
                <span>·</span>
                <time datetime="{{ $project->published_at->toISOString() }}">
                    {{ $project->published_at->format('Y-m-d') }}
                </time>
                @if($project->posts_count > 0)
                <span>·</span>
                <span>{{ $project->posts_count }} entradas</span>
                @endif
            </div>

            <!-- Links -->
            <div class="flex flex-wrap gap-3">
                @if($project->demo_url)
                <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-5 py-2.5 font-mono text-sm font-medium no-underline rounded-md bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white transition-colors">
                    ver_demo →
                </a>
                @endif
                @if($project->repository_url)
                <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-5 py-2.5 font-mono text-sm font-medium no-underline rounded-md text-terminal-muted dark:text-terminal-muted bg-transparent border border-terminal-border dark:border-terminal-border hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">
                    repositorio →
                </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Project Image -->
    @if($project->image)
    <section class="py-8 bg-gray-50 dark:bg-terminal-bg border-b border-gray-200 dark:border-terminal-border">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-terminal-border">
                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full">
            </div>
        </div>
    </section>
    @endif

    <!-- Project Description -->
    <section class="py-12 bg-white dark:bg-terminal-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg dark:prose-invert max-w-none prose-a:text-primary-600 dark:prose-a:text-primary-500 prose-pre:bg-gray-900 dark:prose-pre:bg-terminal-card">
                {!! $project->description !!}
            </div>
        </div>
    </section>

    <!-- Project Posts -->
    @if($project->posts->count() > 0)
    <section class="py-12 bg-gray-50 dark:bg-terminal-bg border-t border-gray-200 dark:border-terminal-border">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="font-mono text-xs text-terminal-dim dark:text-terminal-dim uppercase tracking-wider mb-1"><span class="text-primary-600 dark:text-primary-500">#</span> entradas</p>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Entradas del proyecto</h2>
            </div>

            <div class="space-y-px border border-gray-200 dark:border-terminal-border rounded-lg overflow-hidden bg-gray-200 dark:bg-terminal-border">
                @foreach($project->posts as $post)
                <article class="group bg-white dark:bg-terminal-card hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                    <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center gap-4 sm:gap-6 px-4 sm:px-6 py-4 no-underline text-inherit">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors">
                                {{ $post->title }}
                            </h3>
                            <div class="flex items-center gap-3 mt-1 font-mono text-[11px] text-terminal-dim dark:text-terminal-dim">
                                <time datetime="{{ $post->published_at->toISOString() }}">
                                    {{ $post->published_at->format('Y-m-d') }}
                                </time>
                                @if($post->reading_time)
                                <span>{{ $post->reading_time }} min</span>
                                @endif
                            </div>
                        </div>
                        <span class="font-mono text-terminal-dim dark:text-terminal-dim group-hover:text-primary-600 dark:group-hover:text-primary-500 group-hover:translate-x-1 transition-all">→</span>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Related Projects -->
    <section class="py-12 bg-white dark:bg-terminal-bg border-t border-gray-200 dark:border-terminal-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="font-mono text-xs text-terminal-dim dark:text-terminal-dim uppercase tracking-wider mb-1"><span class="text-primary-600 dark:text-primary-500">#</span> relacionados</p>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Proyectos relacionados</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
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
                    class="group block rounded-lg border border-gray-200 dark:border-terminal-border overflow-hidden bg-white dark:bg-terminal-card hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 no-underline text-inherit">
                    <!-- Card Header -->
                    <div class="flex items-center gap-1.5 px-4 py-2.5 bg-gray-50 dark:bg-terminal-elevated border-b border-gray-200 dark:border-terminal-border font-mono text-[10px] text-terminal-dim dark:text-terminal-dim">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="ml-auto">{{ Str::slug($relatedProject->title) }}/</span>
                    </div>

                    @if($relatedProject->image)
                    <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-terminal-elevated">
                        <img src="{{ Storage::url($relatedProject->image) }}"
                            alt="{{ $relatedProject->title }}"
                            class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-primary-500/5 to-slate-500/5 dark:from-primary-500/10 dark:to-slate-500/10 flex items-center justify-center">
                        <svg class="w-12 h-12 text-primary-500/20 dark:text-primary-500/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    @endif

                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors line-clamp-2">
                            {{ $relatedProject->title }}
                        </h3>
                        <p class="text-sm text-terminal-muted dark:text-terminal-muted line-clamp-2">
                            {{ $relatedProject->summary ?? Str::limit($relatedProject->description, 100) }}
                        </p>
                        <div class="mt-3 font-mono text-xs text-primary-600 dark:text-primary-500">
                            ver_proyecto →
                        </div>
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-terminal-dim dark:text-terminal-dim font-mono text-sm py-8">
                    No hay proyectos relacionados
                </p>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>