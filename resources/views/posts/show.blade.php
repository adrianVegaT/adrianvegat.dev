<x-app-layout>
    <x-slot name="title">{{ $post->meta_title ?? $post->title }}</x-slot>
    <x-slot name="metaDescription">{{ $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}</x-slot>
    <x-slot name="metaKeywords">{{ $post->meta_keywords ?? $post->tags->pluck('name')->implode(', ') }}</x-slot>
    @if($post->featured_image)
    <x-slot name="ogImage">{{ Storage::url($post->featured_image) }}</x-slot>
    @endif

    <article class="bg-white dark:bg-gray-950">
        <!-- Hero Section -->
        <section class="relative bg-white dark:bg-gray-950 overflow-hidden">
            @if($post->featured_image)
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-10 dark:opacity-5">
                <div class="absolute inset-0 bg-gradient-to-b from-white/50 to-white dark:from-gray-950/50 dark:to-gray-950"></div>
            </div>
            @endif

            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm flex-wrap">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                                Inicio
                            </a>
                        </li>
                        <li class="text-gray-400 dark:text-gray-600">/</li>
                        <li>
                            <a href="{{ route('posts.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                                Blog
                            </a>
                        </li>
                        @if($post->project)
                        <li class="text-gray-400 dark:text-gray-600">/</li>
                        <li>
                            <a href="{{ route('projects.show', $post->project->slug) }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                                {{ $post->project->title }}
                            </a>
                        </li>
                        @endif
                        <li class="text-gray-400 dark:text-gray-600">/</li>
                        <li class="text-gray-900 dark:text-white font-medium">{{ Str::limit($post->title, 30) }}</li>
                    </ol>
                </nav>

                <!-- Categories & Tags -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($post->categories as $category)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-primary-400 border border-primary-200 dark:border-primary-800">
                        {{ $category->name }}
                    </span>
                    @endforeach
                </div>

                <!-- Title -->
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    {{ $post->title }}
                </h1>

                <!-- Excerpt -->
                @if($post->excerpt)
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                    {{ $post->excerpt }}
                </p>
                @endif

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="w-8 h-8 rounded-full">
                        <span>{{ $post->user->name }}</span>
                    </div>
                    <span>·</span>
                    <time datetime="{{ $post->published_at->toISOString() }}">
                        {{ $post->published_at->format('d M Y') }}
                    </time>
                    @if($post->reading_time)
                    <span>·</span>
                    <span>{{ $post->reading_time }} min lectura</span>
                    @endif
                    <span>·</span>
                    <span>{{ $post->views_count }} {{ Str::plural('vista', $post->views_count) }}</span>
                </div>
            </div>
        </section>

        <!-- Featured Image -->
        @if($post->featured_image)
        <section class="py-8 bg-gray-50 dark:bg-gray-900/50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full">
                </div>
            </div>
        </section>
        @endif

        <!-- Post Content -->
        <section class="py-12 bg-white dark:bg-gray-950">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-600 dark:prose-p:text-gray-400 prose-a:text-primary-600 dark:prose-a:text-primary-500 prose-strong:text-gray-900 dark:prose-strong:text-white prose-code:text-gray-900 dark:prose-code:text-white prose-pre:bg-gray-900 dark:prose-pre:bg-gray-800">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            #{{ $tag->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Buttons -->
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Compartir</h3>
                    <div class="flex gap-3">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('posts.show', $post->slug)) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <section class="py-12 bg-gray-50 dark:bg-gray-900/50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                @livewire('comment-section', ['post' => $post])
            </div>
        </section>

        <!-- Related Posts -->
        <section class="py-12 bg-white dark:bg-gray-950">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-8">
                    Artículos relacionados
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                    // Obtener posts relacionados
                    $relatedPosts = \App\Models\Post::whereHas('categories', function($query) use ($post) {
                    $query->whereIn('categories.id', $post->categories->pluck('id'));
                    })
                    ->where('id', '!=', $post->id)
                    ->published()
                    ->limit(2)
                    ->get();
                    @endphp

                    @forelse($relatedPosts as $relatedPost)
                    <article class="group bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 overflow-hidden">
                        <a href="{{ route('posts.show', $relatedPost->slug) }}">
                            @if($relatedPost->featured_image)
                            <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800">
                                <img src="{{ Storage::url($relatedPost->featured_image) }}"
                                    alt="{{ $relatedPost->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-3 text-sm text-gray-500 dark:text-gray-400">
                                    <time datetime="{{ $relatedPost->published_at->toISOString() }}">
                                        {{ $relatedPost->published_at->format('d M Y') }}
                                    </time>
                                    @if($relatedPost->reading_time)
                                    <span>·</span>
                                    <span>{{ $relatedPost->reading_time }} min</span>
                                    @endif
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-500 transition-colors line-clamp-2">
                                    {{ $relatedPost->title }}
                                </h3>

                                @if($relatedPost->excerpt)
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                    {{ $relatedPost->excerpt }}
                                </p>
                                @endif
                            </div>
                        </a>
                    </article>
                    @empty
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">
                        No hay artículos relacionados disponibles
                    </p>
                    @endforelse
                </div>
            </div>
        </section>
    </article>
</x-app-layout>