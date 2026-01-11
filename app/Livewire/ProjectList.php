<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Project;

class ProjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $perPage = 12;

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
        $query = Project::with(['categories', 'user'])
            ->published()
            ->ordered();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('summary', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCategory) {
            $query->whereHas('categories', function ($q) {
                $q->where('slug', $this->selectedCategory);
            });
        }

        $projects = $query->paginate($this->perPage);
        $categories = Category::active()->orderBy('name')->get();

        return view('livewire.project-list', [
            'projects' => $projects,
            'categories' => $categories,
        ]);
    }
}
