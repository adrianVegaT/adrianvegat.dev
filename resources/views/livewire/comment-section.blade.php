<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
        Comentarios ({{ $post->comments->count() }})
    </h2>

    @if (session()->has('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
        <p class="text-sm text-green-800 dark:text-green-400">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Comment Form -->
    @auth
    <div class="mb-8">
        <form wire:submit.prevent="submitComment" class="space-y-4">
            @if($replyingToCommentId)
            <div class="flex items-center justify-between p-3 bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg">
                <span class="text-sm text-primary-700 dark:text-primary-400">
                    Respondiendo a comentario...
                </span>
                <button type="button" wire:click="cancelReply" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ $replyingToCommentId ? 'Tu respuesta' : 'Escribe un comentario' }}
                </label>
                <textarea
                    wire:model="comment"
                    id="comment"
                    rows="4"
                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none"
                    placeholder="Comparte tu opinión..."></textarea>
                @error('comment')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                @if($replyingToCommentId)
                <button
                    type="button"
                    wire:click="cancelReply"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Cancelar
                </button>
                @endif
                <button
                    type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ $replyingToCommentId ? 'Responder' : 'Comentar' }}</span>
                    <span wire:loading>Publicando...</span>
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-center">
        <p class="text-gray-600 dark:text-gray-400 mb-4">
            Inicia sesión para dejar un comentario
        </p>
        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors">
            Iniciar sesión
        </a>
    </div>
    @endauth

    <!-- Comments List -->
    <div class="space-y-6">
        @forelse($comments as $comment)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg p-6" id="comment-{{ $comment->id }}">
            <!-- Comment Header -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $comment->created_at->diffForHumans() }}
                            @if($comment->created_at != $comment->updated_at)
                            <span class="text-xs">(editado)</span>
                            @endif
                        </p>
                    </div>
                </div>

                @auth
                @if($comment->user_id === auth()->id() || auth()->user()->hasRole('admin'))
                <div class="flex items-center space-x-2" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-10"
                        style="display: none;">
                        <button
                            wire:click="editComment({{ $comment->id }})"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Editar
                        </button>
                        <button
                            wire:click="deleteComment({{ $comment->id }})"
                            wire:confirm="¿Estás seguro de eliminar este comentario?"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Eliminar
                        </button>
                    </div>
                </div>
                @endif
                @endauth
            </div>

            <!-- Comment Content -->
            <div class="mb-4">
                @if($editingCommentId === $comment->id)
                <div class="space-y-3">
                    <textarea
                        wire:model="editingContent"
                        rows="4"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white resize-none"></textarea>
                    @error('editingContent')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end gap-3">
                        <button
                            wire:click="cancelEdit"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            Cancelar
                        </button>
                        <button
                            wire:click="updateComment"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors">
                            Guardar
                        </button>
                    </div>
                </div>
                @else
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                @endif
            </div>

            <!-- Comment Actions -->
            @auth
            @if($editingCommentId !== $comment->id)
            <div class="flex items-center space-x-4">
                <button
                    wire:click="replyTo({{ $comment->id }})"
                    class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                    Responder
                </button>
            </div>
            @endif
            @endauth

            <!-- Replies -->
            @if($comment->replies->count() > 0)
            <div class="mt-6 ml-8 space-y-6 border-l-2 border-gray-200 dark:border-gray-800 pl-6">
                @foreach($comment->replies as $reply)
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                    <!-- Reply Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $reply->user->avatar_url }}" alt="{{ $reply->user->name }}" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $reply->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $reply->created_at->diffForHumans() }}
                                    @if($reply->created_at != $reply->updated_at)
                                    <span>(editado)</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @auth
                        @if($reply->user_id === auth()->id() || auth()->user()->hasRole('admin'))
                        <div class="flex items-center space-x-2" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>

                            <div x-show="open"
                                @click.away="open = false"
                                x-transition
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-10"
                                style="display: none;">
                                <button
                                    wire:click="editComment({{ $reply->id }})"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Editar
                                </button>
                                <button
                                    wire:click="deleteComment({{ $reply->id }})"
                                    wire:confirm="¿Estás seguro de eliminar esta respuesta?"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        @endif
                        @endauth
                    </div>

                    <!-- Reply Content -->
                    @if($editingCommentId === $reply->id)
                    <div class="space-y-3">
                        <textarea
                            wire:model="editingContent"
                            rows="3"
                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white text-sm resize-none"></textarea>
                        <div class="flex justify-end gap-2">
                            <button
                                wire:click="cancelEdit"
                                class="px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Cancelar
                            </button>
                            <button
                                wire:click="updateComment"
                                class="px-3 py-1.5 text-xs font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors">
                                Guardar
                            </button>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-wrap">{{ $reply->content }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-12 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay comentarios aún</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sé el primero en comentar</p>
        </div>
        @endforelse
    </div>
</div>