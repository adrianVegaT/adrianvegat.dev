<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function getByPost(Post $post): Collection
    {
        return $post->approvedComments()
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        return $comment->fresh();
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function approve(Comment $comment): Comment
    {
        $comment->update(['is_approved' => true]);
        return $comment->fresh();
    }

    public function getPending(): Collection
    {
        return Comment::with(['user', 'post'])
            ->where('is_approved', false)
            ->latest()
            ->get();
    }
}