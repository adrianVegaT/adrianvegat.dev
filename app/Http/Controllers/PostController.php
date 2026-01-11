<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function index()
    {
        $posts = $this->postRepository->getAllPublished(10);
        
        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = $this->postRepository->findBySlug($slug);

        if (!$post || $post->status !== 'published') {
            abort(404);
        }

        // Incrementar vistas
        $this->postRepository->incrementViews($post);

        return view('posts.show', compact('post'));
    }
}