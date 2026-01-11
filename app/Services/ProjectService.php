<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository
    ) {}

    public function createProject(array $data): Project
    {
        // Asegurar que tenga slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Si el estado es published, asegurar que tenga published_at
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $project = $this->projectRepository->create($data);

        // Sincronizar categorías si existen
        if (isset($data['categories'])) {
            $project->categories()->sync($data['categories']);
        }

        return $project;
    }

    public function updateProject(Project $project, array $data): Project
    {
        // Actualizar slug si cambió el título
        if (isset($data['title']) && $data['title'] !== $project->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Si cambia a published y no tiene published_at, agregarlo
        if (isset($data['status']) && $data['status'] === 'published' && !$project->published_at) {
            $data['published_at'] = now();
        }

        $this->projectRepository->update($project, $data);

        // Sincronizar categorías si existen
        if (isset($data['categories'])) {
            $project->categories()->sync($data['categories']);
        }

        return $project->fresh();
    }

    public function deleteProject(Project $project): bool
    {
        return $this->projectRepository->delete($project);
    }

    public function publishProject(Project $project): Project
    {
        return $this->projectRepository->update($project, [
            'status' => 'published',
            'published_at' => $project->published_at ?? now()
        ]);
    }

    protected function storeImage($image): string
    {
        return $image->store('projects', 'public');
    }
}
