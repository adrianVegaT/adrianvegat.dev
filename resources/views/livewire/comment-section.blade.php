<div>
    <div class="mb-8">
        <p class="font-mono text-xs text-terminal-dim dark:text-terminal-dim uppercase tracking-wider mb-1"><span class="text-primary-600 dark:text-primary-500">#</span> comentarios</p>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Comentarios ({{ $post->comments->count() }})</h2>
    </div>

    @if (session()->has('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
        <p class="text-sm text-green-800 dark:text-green-400">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Comment Form (top-level only, not replying) -->
    @if(!$replyingToCommentId)
    <div class="mb-8">
        <form wire:submit.prevent="submitComment" class="space-y-4">
            @guest
            <div>
                <label for="authorName" class="block font-mono text-xs text-terminal-dim dark:text-terminal-dim mb-2">
                    Nombre
                </label>
                <input
                    wire:model="authorName"
                    id="authorName"
                    type="text"
                    maxlength="50"
                    class="w-full px-4 py-2.5 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim"
                    placeholder="Tu nombre...">
                @error('authorName')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            @endguest

            <div>
                <label for="comment" class="block font-mono text-xs text-terminal-dim dark:text-terminal-dim mb-2">
                    Escribe un comentario
                </label>
                <textarea
                    wire:model="comment"
                    id="comment"
                    rows="4"
                    class="w-full px-4 py-3 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim resize-none"
                    placeholder="Comparte tu opinión..."></textarea>
                @error('comment')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="px-6 py-2 font-mono text-xs font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Comentar</span>
                    <span wire:loading>Publicando...</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Comments List -->
    <div class="space-y-4">
        @forelse($comments as $comment)
        <div class="bg-white dark:bg-terminal-card border border-gray-200 dark:border-terminal-border rounded-lg p-5" id="comment-{{ $comment->id }}">
            <!-- Comment Header -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ $comment->avatar_url }}" alt="{{ $comment->display_name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $comment->display_name }}</p>
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
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-terminal-card rounded-lg shadow-lg border border-gray-200 dark:border-terminal-border py-1 z-10"
                        style="display: none;">
                        <button
                            wire:click="editComment({{ $comment->id }})"
                            class="w-full text-left px-4 py-2 font-mono text-xs text-terminal-muted dark:text-terminal-muted hover:bg-gray-100 dark:hover:bg-terminal-elevated">
                            Editar
                        </button>
                        <button
                            wire:click="deleteComment({{ $comment->id }})"
                            wire:confirm="¿Estás seguro de eliminar este comentario?"
                            class="w-full text-left px-4 py-2 font-mono text-xs text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-terminal-elevated">
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
                        class="w-full px-4 py-3 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white resize-none"></textarea>
                    @error('editingContent')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end gap-3">
                        <button
                            wire:click="cancelEdit"
                            class="px-4 py-2 font-mono text-xs text-terminal-muted dark:text-terminal-muted bg-white dark:bg-terminal-card border border-terminal-border dark:border-terminal-border rounded-md hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                            Cancelar
                        </button>
                        <button
                            wire:click="updateComment"
                            class="px-4 py-2 font-mono text-xs text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-md transition-colors">
                            Guardar
                        </button>
                    </div>
                </div>
                @else
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                @endif
            </div>

            <!-- Comment Actions -->
            @if($editingCommentId !== $comment->id)
            <div class="flex items-center space-x-4">
                <button
                    wire:click="replyTo({{ $comment->id }})"
                    class="font-mono text-xs text-primary-600 dark:text-primary-500 hover:text-primary-700 dark:hover:text-primary-300">
                    Responder
                </button>
            </div>
            @endif

            <!-- Inline Reply Form -->
            @if($replyingToCommentId === $comment->id)
            <div class="mt-4 space-y-3">
                <div class="flex items-center justify-between p-3 bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/20 rounded-lg">
                    <span class="font-mono text-xs text-primary-700 dark:text-primary-400">
                        Respondiendo a {{ $comment->display_name }}...
                    </span>
                    <button type="button" wire:click="cancelReply" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="submitComment" class="space-y-3">
                    @guest
                    <div>
                        <label for="authorName-reply-{{ $comment->id }}" class="block font-mono text-xs text-terminal-dim dark:text-terminal-dim mb-2">Nombre</label>
                        <input
                            wire:model="authorName"
                            id="authorName-reply-{{ $comment->id }}"
                            type="text"
                            maxlength="50"
                            class="w-full px-4 py-2.5 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim"
                            placeholder="Tu nombre...">
                        @error('authorName')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    @endguest

                    <div>
                        <label for="comment-reply-{{ $comment->id }}" class="block font-mono text-xs text-terminal-dim dark:text-terminal-dim mb-2">Tu respuesta</label>
                        <textarea
                            wire:model="comment"
                            id="comment-reply-{{ $comment->id }}"
                            rows="3"
                            class="w-full px-4 py-3 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim resize-none"
                            placeholder="Escribe tu respuesta..."></textarea>
                        @error('comment')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button
                            type="button"
                            wire:click="cancelReply"
                            class="px-4 py-2 font-mono text-xs text-terminal-muted dark:text-terminal-muted bg-white dark:bg-terminal-card border border-terminal-border dark:border-terminal-border rounded-md hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-2 font-mono text-xs font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Responder</span>
                            <span wire:loading>Publicando...</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Replies -->
            @if($comment->replies->count() > 0)
            <div class="mt-6 ml-8 space-y-4 border-l-2 border-gray-200 dark:border-terminal-border pl-6">
                @foreach($comment->replies as $reply)
                <div class="bg-gray-50 dark:bg-terminal-elevated rounded-lg p-4">
                    <!-- Reply Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $reply->avatar_url }}" alt="{{ $reply->display_name }}" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $reply->display_name }}</p>
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
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-terminal-card rounded-lg shadow-lg border border-gray-200 dark:border-terminal-border py-1 z-10"
                                style="display: none;">
                                <button
                                    wire:click="editComment({{ $reply->id }})"
                                    class="w-full text-left px-4 py-2 font-mono text-xs text-terminal-muted dark:text-terminal-muted hover:bg-gray-100 dark:hover:bg-terminal-elevated">
                                    Editar
                                </button>
                                <button
                                    wire:click="deleteComment({{ $reply->id }})"
                                    wire:confirm="¿Estás seguro de eliminar esta respuesta?"
                                    class="w-full text-left px-4 py-2 font-mono text-xs text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-terminal-elevated">
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
                            class="w-full px-3 py-2 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white resize-none"></textarea>
                        <div class="flex justify-end gap-2">
                            <button
                                wire:click="cancelEdit"
                                class="px-3 py-1.5 font-mono text-xs text-terminal-muted dark:text-terminal-muted bg-white dark:bg-terminal-card border border-terminal-border dark:border-terminal-border rounded-md hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                                Cancelar
                            </button>
                            <button
                                wire:click="updateComment"
                                class="px-3 py-1.5 font-mono text-xs text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-md transition-colors">
                                Guardar
                            </button>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-wrap">{{ $reply->content }}</p>
                    @endif

                    <!-- Reply Actions -->
                    @if($editingCommentId !== $reply->id && !$replyingToCommentId)
                    <div class="mt-3">
                        <button
                            wire:click="replyTo({{ $reply->id }})"
                            class="font-mono text-xs text-primary-600 dark:text-primary-500 hover:text-primary-700 dark:hover:text-primary-300">
                            Responder
                        </button>
                    </div>
                    @endif

                    <!-- Inline Reply Form (for replies) -->
                    @if($replyingToCommentId === $reply->id)
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between p-3 bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/20 rounded-lg">
                            <span class="font-mono text-xs text-primary-700 dark:text-primary-400">
                                Respondiendo a {{ $reply->display_name }}...
                            </span>
                            <button type="button" wire:click="cancelReply" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit.prevent="submitComment" class="space-y-3">
                            @guest
                            <div>
                                <label for="authorName-replyto-{{ $reply->id }}" class="block font-mono text-xs text-terminal-dim dark:text-terminal-dim mb-2">Nombre</label>
                                <input
                                    wire:model="authorName"
                                    id="authorName-replyto-{{ $reply->id }}"
                                    type="text"
                                    maxlength="50"
                                    class="w-full px-4 py-2.5 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim"
                                    placeholder="Tu nombre...">
                                @error('authorName')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            @endguest

                            <div>
                                <label for="comment-replyto-{{ $reply->id }}" class="block font-mono text-xs text-terminal-dim dark:text-terminal-dim mb-2">Tu respuesta</label>
                                <textarea
                                    wire:model="comment"
                                    id="comment-replyto-{{ $reply->id }}"
                                    rows="3"
                                    class="w-full px-4 py-3 font-mono text-sm bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white placeholder-terminal-muted dark:placeholder-terminal-dim resize-none"
                                    placeholder="Escribe tu respuesta..."></textarea>
                                @error('comment')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-2">
                                <button
                                    type="button"
                                    wire:click="cancelReply"
                                    class="px-3 py-1.5 font-mono text-xs text-terminal-muted dark:text-terminal-muted bg-white dark:bg-terminal-card border border-terminal-border dark:border-terminal-border rounded-md hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-1.5 font-mono text-xs font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove>Responder</span>
                                    <span wire:loading>Publicando...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Sub-replies (level 3, no reply button) -->
                    @if($reply->replies->count() > 0)
                    <div class="mt-4 ml-4 space-y-3 border-l-2 border-gray-300 dark:border-terminal-border-bright pl-4">
                        @foreach($reply->replies as $subReply)
                        <div class="bg-white dark:bg-terminal-card rounded-lg p-3">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $subReply->avatar_url }}" alt="{{ $subReply->display_name }}" class="w-6 h-6 rounded-full">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white text-xs">{{ $subReply->display_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $subReply->created_at->diffForHumans() }}
                                            @if($subReply->created_at != $subReply->updated_at)
                                            <span>(editado)</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                @auth
                                @if($subReply->user_id === auth()->id() || auth()->user()->hasRole('admin'))
                                <div class="flex items-center space-x-1" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute right-0 mt-2 w-40 bg-white dark:bg-terminal-card rounded-lg shadow-lg border border-gray-200 dark:border-terminal-border py-1 z-10"
                                        style="display: none;">
                                        <button wire:click="editComment({{ $subReply->id }})"
                                            class="w-full text-left px-3 py-1.5 font-mono text-xs text-terminal-muted dark:text-terminal-muted hover:bg-gray-100 dark:hover:bg-terminal-elevated">
                                            Editar
                                        </button>
                                        <button wire:click="deleteComment({{ $subReply->id }})"
                                            wire:confirm="¿Estás seguro de eliminar esta respuesta?"
                                            class="w-full text-left px-3 py-1.5 font-mono text-xs text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-terminal-elevated">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                                @endif
                                @endauth
                            </div>

                            @if($editingCommentId === $subReply->id)
                            <div class="space-y-2">
                                <textarea wire:model="editingContent" rows="2"
                                    class="w-full px-3 py-1.5 font-mono text-xs bg-white dark:bg-terminal-card border border-gray-300 dark:border-terminal-border rounded-md focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white resize-none"></textarea>
                                <div class="flex justify-end gap-2">
                                    <button wire:click="cancelEdit"
                                        class="px-2.5 py-1 font-mono text-xs text-terminal-muted dark:text-terminal-muted bg-white dark:bg-terminal-card border border-terminal-border dark:border-terminal-border rounded-md hover:bg-gray-50 dark:hover:bg-terminal-elevated transition-colors">
                                        Cancelar
                                    </button>
                                    <button wire:click="updateComment"
                                        class="px-2.5 py-1 font-mono text-xs text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-md transition-colors">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-700 dark:text-gray-300 text-xs whitespace-pre-wrap">{{ $subReply->content }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-12 bg-white dark:bg-terminal-card border border-gray-200 dark:border-terminal-border rounded-lg">
            <svg class="mx-auto h-10 w-10 text-terminal-muted dark:text-terminal-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <h3 class="mt-2 font-mono text-sm text-gray-900 dark:text-white">No hay comentarios aún</h3>
            <p class="mt-1 font-mono text-xs text-terminal-muted dark:text-terminal-dim">Sé el primero en comentar</p>
        </div>
        @endforelse
    </div>
</div>