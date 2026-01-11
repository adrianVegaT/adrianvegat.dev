<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Services\PostService;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected PostRepositoryInterface $postRepository,
        protected CategoryRepositoryInterface $categoryRepository,
        protected TagRepositoryInterface $tagRepository
    ) {
        // El middleware ya está en las rutas
    }

    public function index()
    {
        $posts = Post::with(['user', 'project', 'categories'])
            ->withCount('comments')
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $projects = Project::where('status', 'published')->get();
        $categories = $this->categoryRepository->getActive();
        $tags = \App\Models\Tag::withCount('posts')->orderBy('name')->get(); // Agregar esta línea

        return view('admin.posts.create', compact('projects', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ]);

        try {
            $validated['user_id'] = auth()->id();

            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
            }

            $post = $this->postService->createPost($validated);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Entrada creada exitosamente.');
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

    public function edit(Post $post)
    {
        $projects = Project::where('status', 'published')->get();
        $categories = $this->categoryRepository->getActive();
        $tags = \App\Models\Tag::withCount('posts')->orderBy('name')->get(); // Agregar esta línea

        return view('admin.posts.edit', compact('post', 'projects', 'categories', 'tags'));
    }
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ]);

        try {
            if ($request->hasFile('featured_image')) {
                // Eliminar imagen anterior si existe
                if ($post->featured_image) {
                    Storage::disk('public')->delete($post->featured_image);
                }
                $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
            }

            $this->postService->updatePost($post, $validated);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Entrada actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la entrada: ' . $e->getMessage());
        }
    }

    public function destroy(Post $post)
    {
        try {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $this->postService->deletePost($post);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Entrada eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la entrada: ' . $e->getMessage());
        }
    }

    public function publish(Post $post)
    {
        try {
            $this->postService->publishPost($post);

            return back()->with('success', 'Entrada publicada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al publicar la entrada: ' . $e->getMessage());
        }
    }
}
