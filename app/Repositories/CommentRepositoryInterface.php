<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    public function getByPost(Post $post): Collection;
    public function create(array $data): Comment;
    public function update(Comment $comment, array $data): Comment;
    public function delete(Comment $comment): bool;
    public function approve(Comment $comment): Comment;
    public function getPending(): Collection;
}