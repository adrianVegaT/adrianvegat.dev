<div>
    <!-- Filtros y búsqueda -->
    <div class="mb-8 space-y-4">
        <!-- Buscador -->
        <div class="relative">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar proyectos..."
                class="w-full px-4 py-3 pl-11 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
            >
            <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Filtro por categorías -->
        <div class="flex flex-wrap gap-2">
            <button 
                wire:click="$set('selectedCategory', '')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $selectedCategory === '' ? 'bg-primary-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}"
            >
                Todos
            </button>
            @foreach($categories as $category)
            <button 
                wire:click="$set('selectedCategory', '{{ $category->slug }}')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $selectedCategory === $category->slug ? 'bg-primary-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}"
            >
                {{ $category->name }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Resultados -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($projects as $project)
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No se encontraron proyectos</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Intenta con otros términos de búsqueda</p>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($projects->hasPages())
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
    @endif
</div>