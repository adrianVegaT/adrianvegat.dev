<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPublished(int $perPage = 10): LengthAwarePaginator
    {
        return Post::with(['user', 'project', 'categories', 'tags'])
            ->withCount('comments')
            ->published()
            ->recent()
            ->paginate($perPage);
    }

    public function getRecentPublished(int $limit = 5): Collection
    {
        return Post::with(['user', 'project', 'categories'])
            ->published()
            ->recent()
            ->limit($limit)
            ->get();
    }

    public function findBySlug(string $slug): ?Post
    {
        return Post::with([
            'user',
            'project',
            'categories',
            'tags',
            'approvedComments.user',
            'approvedComments.replies.user'
        ])
            ->where('slug', $slug)
            ->first();
    }

    public function getByProject(int $projectId, int $perPage = 10): LengthAwarePaginator
    {
        return Post::with(['user', 'categories', 'tags'])
            ->where('project_id', $projectId)
            ->published()
            ->recent()
            ->paginate($perPage);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post->fresh();
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Post::with(['user', 'project', 'categories', 'tags'])
            ->withCount('comments')
            ->latest()
            ->paginate($perPage);
    }

    public function attachCategories(Post $post, array $categoryIds): void
    {
        $post->categories()->sync($categoryIds);
    }

    public function attachTags(Post $post, array $tagIds): void
    {
        $post->tags()->sync($tagIds);
    }

    public function incrementViews(Post $post): void
    {
        $post->incrementViews();
    }
}