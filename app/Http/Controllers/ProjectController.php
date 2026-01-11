<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository
    ) {}

    public function index()
    {
        $projects = $this->projectRepository->getAllPublished(12);
        
        return view('projects.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = $this->projectRepository->findBySlug($slug);

        if (!$project || $project->status !== 'published') {
            abort(404);
        }

        return view('projects.show', compact('project'));
    }
}