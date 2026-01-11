<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllPublished(int $perPage = 12): LengthAwarePaginator
    {
        return Project::with(['categories', 'user'])
            ->published()
            ->ordered()
            ->paginate($perPage);
    }

    public function getFeatured(): Collection
    {
        return Project::with(['categories', 'user'])
            ->published()
            ->featured()
            ->ordered()
            ->get();
    }

    public function findBySlug(string $slug): ?Project
    {
        return Project::with(['categories', 'user', 'posts' => function ($query) {
            $query->published()->recent();
        }])
            ->where('slug', $slug)
            ->first();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh();
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Project::with(['categories', 'user'])
            ->withCount('posts')
            ->latest()
            ->paginate($perPage);
    }

    public function attachCategories(Project $project, array $categoryIds): void
    {
        $project->categories()->sync($categoryIds);
    }
}