<x-app-layout>
    <!-- Hero Section -->
    <section class="bg-white dark:bg-terminal-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <!-- Terminal Block -->
            <div class="max-w-3xl rounded-lg border border-gray-200 dark:border-terminal-border overflow-hidden bg-gray-50 dark:bg-terminal-card">
                <!-- Terminal Header -->
                <div class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-terminal-elevated border-b border-gray-200 dark:border-terminal-border">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="flex-1 text-center font-mono text-[11px] text-terminal-dim dark:text-terminal-dim">adrian@dev ~ about.sh</span>
                </div>

                <!-- Terminal Body -->
                <div class="p-6 sm:p-8 font-mono text-sm leading-relaxed space-y-1">
                    <div class="terminal-line">
                        <span class="text-terminal-dim dark:text-terminal-dim italic">#!/bin/bash</span>
                    </div>
                    <div class="terminal-line">
                        <span class="text-terminal-dim dark:text-terminal-dim italic"># about.sh - Quién soy</span>
                    </div>
                    <div class="terminal-line">&nbsp;</div>
                    <div class="terminal-line">
                        <span class="text-primary-600 dark:text-primary-500">$</span> <span class="text-cyan-600 dark:text-cyan-400">echo</span> <span class="text-primary-600 dark:text-primary-400">"Hola, soy <span class="text-primary-600 dark:text-primary-500 font-semibold">Adrian Vega</span>"</span>
                    </div>
                    <div class="terminal-line">
                        <span class="text-terminal-muted dark:text-terminal-muted">Hola, soy Adrian Vega</span>
                    </div>
                    <div class="terminal-line">&nbsp;</div>
                    <div class="terminal-line">
                        <span class="text-primary-600 dark:text-primary-500">$</span> <span class="text-cyan-600 dark:text-cyan-400">cat</span> <span class="text-amber-600 dark:text-amber-400">--role</span> <span class="text-primary-600 dark:text-primary-400">"Full Stack Developer"</span> <span class="text-amber-600 dark:text-amber-400">--focus</span> <span class="text-primary-600 dark:text-primary-400">"TypeScript & IA"</span>
                    </div>
                    <div class="terminal-line">
                        <span class="text-terminal-muted dark:text-terminal-muted">Desarrollador backend con base en PHP, en transición activa hacia TypeScript y herramientas de IA. Este sitio es el registro público de ese proceso: decisiones, aprendizajes y proyectos en tiempo real.</span>
                    </div>
                    <div class="terminal-line">&nbsp;</div>
                    <div class="terminal-line">
                        <span class="text-primary-600 dark:text-primary-500">$</span> <span class="text-cyan-600 dark:text-cyan-400">ls</span> <span class="text-amber-600 dark:text-amber-400">./stack/</span>
                    </div>
                </div>
            </div>

            <!-- Hero Actions -->
            <div class="max-w-3xl mt-8">
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('projects.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 font-mono text-sm font-medium no-underline rounded-md bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white transition-colors">
                        ./ver_proyectos.sh
                    </a>
                    <a href="{{ route('posts.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 font-mono text-sm font-medium no-underline rounded-md text-terminal-muted dark:text-terminal-muted bg-transparent border border-terminal-border dark:border-terminal-border hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">
                        cat blog/
                    </a>
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="max-w-3xl mt-12 pt-8 border-t border-gray-200 dark:border-terminal-border">
                <p class="font-mono text-[11px] text-terminal-dim dark:text-terminal-dim uppercase tracking-wider mb-3">Stack tecnológico</p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 font-mono text-xs rounded border border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted bg-gray-50 dark:bg-terminal-elevated hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">laravel</span>
                    <span class="px-3 py-1.5 font-mono text-xs rounded border border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted bg-gray-50 dark:bg-terminal-elevated hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">vue.js</span>
                    <span class="px-3 py-1.5 font-mono text-xs rounded border border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted bg-gray-50 dark:bg-terminal-elevated hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">python</span>
                    <span class="px-3 py-1.5 font-mono text-xs rounded border border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted bg-gray-50 dark:bg-terminal-elevated hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">tensorflow</span>
                    <span class="px-3 py-1.5 font-mono text-xs rounded border border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted bg-gray-50 dark:bg-terminal-elevated hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">arduino</span>
                    <span class="px-3 py-1.5 font-mono text-xs rounded border border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted bg-gray-50 dark:bg-terminal-elevated hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">docker</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    @if($featuredProjects->count() > 0)
    <section class="py-16 sm:py-20 bg-gray-50 dark:bg-terminal-bg border-t border-gray-200 dark:border-terminal-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <p class="font-mono text-xs text-terminal-dim dark:text-terminal-dim uppercase tracking-wider mb-1"><span class="text-primary-600 dark:text-primary-500">#</span> proyectos</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Proyectos destacados</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}"
                    class="group block rounded-lg border border-gray-200 dark:border-terminal-border overflow-hidden bg-white dark:bg-terminal-card hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 no-underline text-inherit">
                    <!-- Card Header -->
                    <div class="flex items-center gap-1.5 px-4 py-2.5 bg-gray-50 dark:bg-terminal-elevated border-b border-gray-200 dark:border-terminal-border font-mono text-[10px] text-terminal-dim dark:text-terminal-dim">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="ml-auto">{{ Str::slug($project->title) }}/</span>
                    </div>

                    @if($project->image)
                    <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-terminal-elevated">
                        <img src="{{ Storage::url($project->image) }}"
                            alt="{{ $project->title }}"
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
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach($project->categories as $category)
                            <span class="px-2 py-0.5 font-mono text-[10px] rounded font-medium bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-400">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors">
                            {{ $project->title }}
                        </h3>
                        <p class="text-sm text-terminal-muted dark:text-terminal-muted line-clamp-2">
                            {{ $project->summary ?? Str::limit($project->description, 100) }}
                        </p>

                        <div class="mt-4 flex items-center font-mono text-xs text-primary-600 dark:text-primary-500">
                            ver_detalles <span class="ml-1 group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            @if($projects->count() > 0)
            <div class="text-center mt-8">
                <a href="{{ route('projects.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 font-mono text-sm no-underline rounded-md text-terminal-muted dark:text-terminal-muted bg-transparent border border-terminal-border dark:border-terminal-border hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">
                    ver_todos →
                </a>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Recent Posts -->
    @if($recentPosts->count() > 0)
    <section class="py-16 sm:py-20 bg-white dark:bg-terminal-bg border-t border-gray-200 dark:border-terminal-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <p class="font-mono text-xs text-terminal-dim dark:text-terminal-dim uppercase tracking-wider mb-1"><span class="text-primary-600 dark:text-primary-500">#</span> blog</p>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Últimas entradas</h2>
                </div>
                <a href="{{ route('posts.index') }}"
                    class="hidden sm:inline-flex items-center font-mono text-xs no-underline text-primary-600 dark:text-primary-500 hover:underline">
                    ver_todas →
                </a>
            </div>

            <div class="space-y-px border border-gray-200 dark:border-terminal-border rounded-lg overflow-hidden bg-gray-200 dark:bg-terminal-border">
                @foreach($recentPosts as $index => $post)
                <article class="group bg-white dark:bg-terminal-card hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                    <a href="{{ route('posts.show', $post->slug) }}"
                        class="flex items-center gap-4 sm:gap-6 px-4 sm:px-6 py-4 no-underline text-inherit">
                        <span class="font-mono text-sm text-terminal-dim dark:text-terminal-dim min-w-[28px]">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors truncate">
                                {{ $post->title }}
                            </h3>
                            <div class="flex items-center gap-3 mt-1 font-mono text-[11px] text-terminal-dim dark:text-terminal-dim">
                                <time datetime="{{ $post->published_at->toISOString() }}">
                                    {{ $post->published_at->format('Y-m-d') }}
                                </time>
                                @if($post->reading_time)
                                <span>{{ $post->reading_time }} min</span>
                                @endif
                                @if($post->categories->first())
                                <span class="text-primary-600 dark:text-primary-500">{{ $post->categories->first()->name }}</span>
                                @endif
                            </div>
                        </div>

                        <span class="font-mono text-terminal-dim dark:text-terminal-dim group-hover:text-primary-600 dark:group-hover:text-primary-500 group-hover:translate-x-1 transition-all">→</span>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="text-center mt-8 sm:hidden">
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center font-mono text-xs no-underline text-primary-600 dark:text-primary-500 hover:underline">
                    ver_todas →
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 sm:py-20 bg-gray-50 dark:bg-terminal-bg border-t border-gray-200 dark:border-terminal-border">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 dark:border-terminal-border overflow-hidden bg-white dark:bg-terminal-card">
                <!-- Terminal Header -->
                <div class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-terminal-elevated border-b border-gray-200 dark:border-terminal-border">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="flex-1 text-center font-mono text-[11px] text-terminal-dim dark:text-terminal-dim">contact.sh</span>
                </div>

                <div class="p-8 sm:p-10 text-center">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        ¿Estás en un proceso similar?
                    </h2>
                    <p class="text-terminal-muted dark:text-terminal-muted max-w-md mx-auto mb-6">
                        Si estás transitando de un stack a otro, explorando IA o simplemente navegando el ruido de la industria, me interesa saber cómo lo estás viviendo.
                    </p>
                    <a href="mailto:adrianvegat@gmail.com"
                        class="inline-flex items-center gap-2 px-5 py-2.5 font-mono text-sm font-medium no-underline rounded-md bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white transition-colors">
                        $ mail -to adrianvegat@gmail.com
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>