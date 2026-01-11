<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'post']);

        if ($request->filled('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $comments = $query->latest()->paginate(20);
        $pendingCount = Comment::where('is_approved', false)->count();

        return view('admin.comments.index', compact('comments', 'pendingCount'));
    }

    public function pending()
    {
        $comments = Comment::with(['user', 'post'])
            ->where('is_approved', false)
            ->latest()
            ->paginate(20);

        return view('admin.comments.pending', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);

        return back()->with('success', 'Comentario aprobado exitosamente.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comentario eliminado exitosamente.');
    }
}