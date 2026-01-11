<x-admin-layout>
    <x-slot name="title">Comentarios</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Comentarios</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gestiona los comentarios del blog</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.comments.pending') }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400 text-sm font-medium rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/30 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pendientes ({{ $pendingCount }})
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Buscar comentarios..."
                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                    >
                </div>
                <select 
                    name="status" 
                    class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                >
                    <option value="">Todos los estados</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobados</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendientes</option>
                </select>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white text-sm font-medium rounded-lg transition-colors">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Comments List -->
        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-start gap-4">
                        <!-- Avatar -->
                        <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-12 h-12 rounded-full flex-shrink-0">

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $comment->created_at->diffForHumans() }}
                                        @if($comment->parent_id)
                                            · <span class="text-primary-600 dark:text-primary-400">Respuesta</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($comment->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400">
                                            Aprobado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400">
                                            Pendiente
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Comment Text -->
                            <p class="text-gray-700 dark:text-gray-300 mb-3 whitespace-pre-wrap">{{ $comment->content }}</p>

                            <!-- Post Reference -->
                            <a href="{{ route('posts.show', $comment->post->slug) }}#comment-{{ $comment->id }}" target="_blank" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                {{ Str::limit($comment->post->title, 50) }}
                            </a>

                            <!-- Actions -->
                            <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
                                @if(!$comment->is_approved)
                                    <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium">
                                            Aprobar
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay comentarios</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if(request('search') || request('status'))
                            No se encontraron comentarios con los filtros seleccionados.
                        @else
                            Aún no hay comentarios en el blog.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($comments->hasPages())
            <div class="mt-6">
                {{ $comments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>