<x-admin-layout>
    <x-slot name="title">Comentarios Pendientes</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Comentarios Pendientes</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Revisa y aprueba comentarios</p>
            </div>
            <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Todos los comentarios
            </a>
        </div>

        <!-- Pending Comments -->
        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="bg-white dark:bg-gray-900 rounded-xl border-2 border-yellow-200 dark:border-yellow-800 p-6">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400">
                                    Pendiente de aprobación
                                </span>
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
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:hover:bg-green-500 text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Aprobar
                                    </button>
                                </form>
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 text-red-600 dark:text-red-400 bg-white dark:bg-gray-900 border border-red-300 dark:border-red-800 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-sm font-medium transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay comentarios pendientes</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Todos los comentarios han sido revisados.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($comments->hasPages())
            <div class="mt-6">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>