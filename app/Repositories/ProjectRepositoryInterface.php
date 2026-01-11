<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAllPublished(int $perPage = 12): LengthAwarePaginator;
    public function getFeatured(): Collection;
    public function findBySlug(string $slug): ?Project;
    public function create(array $data): Project;
    public function update(Project $project, array $data): Project;
    public function delete(Project $project): bool;
    public function getAll(int $perPage = 15): LengthAwarePaginator;
    public function attachCategories(Project $project, array $categoryIds): void;
}