<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected TagRepositoryInterface $tagRepository
    ) {}

    public function createPost(array $data): Post
    {
        // Asegurar que tenga slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Si el estado es published, asegurar que tenga published_at
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Extraer tags antes de crear
        $tags = $data['tags'] ?? null;
        unset($data['tags']);

        // Extraer categorías antes de crear
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $post = $this->postRepository->create($data);

        // Calcular tiempo de lectura
        $post->calculateReadingTime();

        // Sincronizar categorías
        if (!empty($categories)) {
            $post->categories()->sync($categories);
        }

        // Manejar tags
        if ($tags) {
            $this->handleTags($post, $tags);
        }

        return $post->fresh();
    }

    public function updatePost(Post $post, array $data): Post
    {
        // Actualizar slug si cambió el título
        if (isset($data['title']) && $data['title'] !== $post->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Si cambia a published y no tiene published_at, agregarlo
        if (isset($data['status']) && $data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        // Extraer tags antes de actualizar
        $tags = $data['tags'] ?? null;
        unset($data['tags']);

        // Extraer categorías antes de actualizar
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $this->postRepository->update($post, $data);

        // Recalcular tiempo de lectura si cambió el contenido
        if (isset($data['content'])) {
            $post->calculateReadingTime();
        }

        // Sincronizar categorías
        if (isset($categories)) {
            $post->categories()->sync($categories);
        }

        // Manejar tags
        if ($tags !== null) {
            $this->handleTags($post, $tags);
        }

        return $post->fresh();
    }

    public function deletePost(Post $post): bool
    {
        // Eliminar imagen si existe
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        return $this->postRepository->delete($post);
    }

    public function publishPost(Post $post): Post
    {
        return $this->postRepository->update($post, [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    protected function storeImage($image): string
    {
        return $image->store('posts', 'public');
    }

    /**
     * Manejar la sincronización de tags
     * 
     * @param Post $post
     * @param string|array $tags - Puede ser string separado por comas o array
     */
    protected function handleTags(Post $post, string|array $tags): void
    {
        // Si viene como string, convertir a array
        if (is_string($tags)) {
            $tags = array_map('trim', explode(',', $tags));
            $tags = array_filter($tags); // Remover vacíos
        }

        if (empty($tags)) {
            $post->tags()->sync([]);
            return;
        }

        $tagIds = [];

        foreach ($tags as $tagName) {
            $tagName = trim($tagName);

            if (empty($tagName)) {
                continue;
            }

            // Buscar o crear el tag
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                [
                    'name' => $tagName,
                    'color' => $this->getRandomColor()
                ]
            );

            $tagIds[] = $tag->id;
        }

        // Sincronizar los tags con el post
        $post->tags()->sync($tagIds);
    }

    /**
     * Obtener un color aleatorio para tags
     */
    protected function getRandomColor(): string
    {
        $colors = [
            '#3B82F6', // blue
            '#10B981', // green
            '#F59E0B', // amber
            '#EF4444', // red
            '#8B5CF6', // violet
            '#EC4899', // pink
            '#06B6D4', // cyan
            '#84CC16', // lime
        ];

        return $colors[array_rand($colors)];
    }
}
