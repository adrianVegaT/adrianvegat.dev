<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public Post $post;
    public $comment = '';
    public $parentId = null;
    public $editingCommentId = null;
    public $editingContent = '';
    public $replyingToCommentId = null;
    public $authorName = '';
    public $authorEmail = '';

    protected function rules()
    {
        $rules = [
            'comment' => 'required|string|max:1000|min:3',
        ];

        if (!Auth::check()) {
            $rules['authorName'] = 'required|string|max:50|min:2';
        }

        return $rules;
    }

    protected $messages = [
        'comment.required' => 'El comentario no puede estar vacío.',
        'comment.max' => 'El comentario no puede tener más de 1000 caracteres.',
        'comment.min' => 'El comentario debe tener al menos 3 caracteres.',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;

        if (!Auth::check()) {
            $this->authorName = $this->generateNickname();
        }
    }

    protected function generateNickname(): string
    {
        $length = random_int(5, 8);
        $numDigits = random_int(1, min(3, $length - 1));
        $numLetters = $length - $numDigits;

        $nickname = '';
        for ($i = 0; $i < $numLetters; $i++) {
            $nickname .= chr(random_int(97, 122));
        }
        for ($i = 0; $i < $numDigits; $i++) {
            $nickname .= random_int(0, 9);
        }

        return $nickname;
    }

    public function submitComment()
    {
        $this->validate();

        $data = [
            'post_id' => $this->post->id,
            'content' => $this->comment,
            'parent_id' => $this->parentId,
            'is_approved' => true,
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            $data['author_name'] = $this->authorName;
        }

        Comment::create($data);

        $this->comment = '';
        $this->parentId = null;
        $this->replyingToCommentId = null;

        $this->post->load('approvedComments.user', 'approvedComments.replies.user');

        session()->flash('success', 'Comentario publicado exitosamente.');
    }

    public function replyTo($commentId)
    {
        $this->replyingToCommentId = $commentId;
        $this->parentId = $commentId;
        $this->comment = '';
    }

    public function cancelReply()
    {
        $this->replyingToCommentId = null;
        $this->parentId = null;
        $this->comment = '';
    }

    public function editComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return;
        }

        $this->editingCommentId = $commentId;
        $this->editingContent = $comment->content;
    }

    public function updateComment()
    {
        $this->validate([
            'editingContent' => 'required|string|max:1000|min:3',
        ]);

        $comment = Comment::findOrFail($this->editingCommentId);

        if ($comment->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return;
        }

        $comment->update([
            'content' => $this->editingContent,
        ]);

        $this->editingCommentId = null;
        $this->editingContent = '';

        $this->post->load('approvedComments.user', 'approvedComments.replies.user');

        session()->flash('success', 'Comentario actualizado exitosamente.');
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingContent = '';
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return;
        }

        $comment->delete();

        $this->post->load('approvedComments.user', 'approvedComments.replies.user');

        session()->flash('success', 'Comentario eliminado exitosamente.');
    }

    public function render()
    {
        return view('livewire.comment-section', [
            'comments' => $this->post->approvedComments,
        ]);
    }
}
