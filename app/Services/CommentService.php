<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepositoryInterface;

class CommentService
{
    public function __construct(
        protected CommentRepositoryInterface $commentRepository
    ) {}

    public function createComment(Post $post, int $userId, string $content, ?int $parentId = null): Comment
    {
        return $this->commentRepository->create([
            'post_id' => $post->id,
            'user_id' => $userId,
            'content' => $content,
            'parent_id' => $parentId,
            'is_approved' => true, // Auto-aprobar, puedes cambiar esto
        ]);
    }

    public function updateComment(Comment $comment, string $content): Comment
    {
        return $this->commentRepository->update($comment, [
            'content' => $content,
        ]);
    }

    public function deleteComment(Comment $comment): bool
    {
        return $this->commentRepository->delete($comment);
    }

    public function approveComment(Comment $comment): Comment
    {
        return $this->commentRepository->approve($comment);
    }
}