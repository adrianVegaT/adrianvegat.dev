<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function getAllPublished(int $perPage = 10): LengthAwarePaginator;
    public function getRecentPublished(int $limit = 5): Collection;
    public function findBySlug(string $slug): ?Post;
    public function getByProject(int $projectId, int $perPage = 10): LengthAwarePaginator;
    public function create(array $data): Post;
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): bool;
    public function getAll(int $perPage = 15): LengthAwarePaginator;
    public function attachCategories(Post $post, array $categoryIds): void;
    public function attachTags(Post $post, array $tagIds): void;
    public function incrementViews(Post $post): void;
}