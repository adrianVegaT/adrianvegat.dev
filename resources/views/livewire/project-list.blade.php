<div>
    <div class="mb-8 space-y-4">
        <div class="relative">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar proyectos..."
                class="w-full px-4 py-2.5 pl-10 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-text-terminal-muted dark:placeholder-terminal-dim"
            >
            <svg class="absolute left-3 top-3 w-4 h-4 text-terminal-muted dark:text-terminal-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <div class="flex flex-wrap gap-2">
            <button
                wire:click="$set('selectedCategory', '')"
                class="px-3 py-1.5 rounded text-[11px] font-mono font-medium transition-colors border {{ $selectedCategory === '' ? 'bg-primary-600 border-primary-600 text-white' : 'bg-white dark:bg-terminal-card border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500' }}"
            >
                Todos
            </button>
            @foreach($categories as $category)
            <button
                wire:click="$set('selectedCategory', '{{ $category->slug }}')"
                class="px-3 py-1.5 rounded text-[11px] font-mono font-medium transition-colors border {{ $selectedCategory === $category->slug ? 'bg-primary-600 border-primary-600 text-white' : 'bg-white dark:bg-terminal-card border-terminal-border dark:border-terminal-border text-terminal-muted dark:text-terminal-muted hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-500' }}"
            >
                {{ $category->name }}
            </button>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @forelse($projects as $project)
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
                <svg class="w-10 h-10 text-primary-500/20 dark:text-primary-500/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
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
        @empty
        <div class="col-span-full text-center py-12 bg-white dark:bg-terminal-card rounded-lg border border-gray-200 dark:border-terminal-border">
            <svg class="mx-auto h-10 w-10 text-terminal-muted dark:text-terminal-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-2 font-mono text-sm text-gray-900 dark:text-white">No se encontraron proyectos</h3>
            <p class="mt-1 font-mono text-xs text-terminal-muted dark:text-terminal-dim">Intenta con otros términos de búsqueda</p>
        </div>
        @endforelse
    </div>

    @if($projects->hasPages())
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
    @endif
</div>