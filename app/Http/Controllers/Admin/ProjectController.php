<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected ProjectRepositoryInterface $projectRepository,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
        // El middleware ya está en las rutas
    }

    public function index()
    {
        $projects = Project::with(['user', 'categories'])
            ->withCount('posts')
            ->latest()
            ->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getActive();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'repository_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'subdomain' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['user_id'] = auth()->id();
            $validated['is_featured'] = $request->has('is_featured');

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('projects', 'public');
            }

            $project = $this->projectService->createProject($validated);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Proyecto creado exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Por favor, verifica los campos del formulario');
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Error de base de datos al crear proyecto: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al guardar en la base de datos. Por favor, intenta nuevamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear proyecto: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error inesperado. Por favor, intenta nuevamente o contacta al administrador');
        }
    }

    public function edit(Project $project)
    {
        $categories = $this->categoryRepository->getActive();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'repository_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'subdomain' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_featured'] = $request->has('is_featured');

            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                $validated['image'] = $request->file('image')->store('projects', 'public');
            }

            $this->projectService->updateProject($project, $validated);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Proyecto actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
        }
    }

    public function destroy(Project $project)
    {
        try {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $this->projectService->deleteProject($project);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Proyecto eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
        }
    }

    public function publish(Project $project)
    {
        try {
            $this->projectService->publishProject($project);

            return back()->with('success', 'Proyecto publicado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al publicar el proyecto: ' . $e->getMessage());
        }
    }
}
