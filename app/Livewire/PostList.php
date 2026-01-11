<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Post;

class PostList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::with(['user', 'project', 'categories', 'tags'])
            ->withCount('comments')
            ->published()
            ->recent();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCategory) {
            $query->whereHas('categories', function($q) {
                $q->where('slug', $this->selectedCategory);
            });
        }
        
        $posts = $query->paginate($this->perPage);
        $categories = Category::active()->orderBy('name')->get();

        return view('livewire.post-list', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
}