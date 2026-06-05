<div>
    <div class="mb-8 space-y-4">
        <div class="relative">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar artículos..."
                class="w-full px-4 py-2.5 pl-10 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim"
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

    <div class="space-y-px border border-gray-200 dark:border-terminal-border rounded-lg overflow-hidden bg-gray-200 dark:bg-terminal-border mb-8">
        @forelse($posts as $index => $post)
        <article class="group bg-white dark:bg-terminal-card hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center gap-4 sm:gap-6 px-4 sm:px-6 py-4 no-underline text-inherit">
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
                        @if($post->comments_count > 0)
                        <span>{{ $post->comments_count }} comentarios</span>
                        @endif
                    </div>
                </div>

                @if($post->categories->first())
                <span class="hidden sm:inline px-2 py-0.5 font-mono text-[10px] rounded font-medium bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-400">
                    {{ $post->categories->first()->name }}
                </span>
                @endif
                <span class="font-mono text-terminal-dim dark:text-terminal-dim group-hover:text-primary-600 dark:group-hover:text-primary-500 group-hover:translate-x-1 transition-all">→</span>
            </a>
        </article>
        @empty
        <div class="text-center py-12 bg-white dark:bg-terminal-card">
            <svg class="mx-auto h-10 w-10 text-terminal-muted dark:text-terminal-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-2 font-mono text-sm text-gray-900 dark:text-white">No se encontraron artículos</h3>
            <p class="mt-1 font-mono text-xs text-terminal-muted dark:text-terminal-dim">Intenta con otros términos de búsqueda</p>
        </div>
        @endforelse
    </div>

    @if($posts->hasPages())
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @endif
</div>