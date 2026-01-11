<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        $this->authorize('create comments');

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $this->commentService->createComment(
            $post,
            auth()->id(),
            $validated['content'],
            $validated['parent_id'] ?? null
        );

        return back()->with('success', 'Comentario publicado exitosamente.');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $this->commentService->updateComment($comment, $validated['content']);

        return back()->with('success', 'Comentario actualizado exitosamente.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $this->commentService->deleteComment($comment);

        return back()->with('success', 'Comentario eliminado exitosamente.');
    }
}