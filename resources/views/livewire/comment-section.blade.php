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
    <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
        <p class="text-gray-600 dark:text-gray-400 mb-4 text-center">
            Inicia sesión para dejar un comentario
        </p>
        <div class="space-y-3">
            <a href="{{ route('social.redirect', 'google') . '?intended=' . urlencode(url()->current()) }}"
                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Continuar con Google
            </a>

            <a href="{{ route('social.redirect', 'github') . '?intended=' . urlencode(url()->current()) }}"
                class="w-full flex items-center justify-center px-4 py-2 border border-gray-800 rounded-md shadow-sm bg-gray-800 text-sm font-medium text-white hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                </svg>
                Continuar con GitHub
            </a>
        </div>
        <p class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('login') . '?intended=' . urlencode(url()->current()) }}" class="text-primary-600 dark:text-primary-400 hover:underline">
                Entrar con email
            </a>
        </p>
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