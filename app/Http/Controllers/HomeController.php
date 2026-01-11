<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\PostRepositoryInterface;

class HomeController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository,
        protected PostRepositoryInterface $postRepository
    ) {}

    public function index()
    {
        $featuredProjects = $this->projectRepository->getFeatured();
        $projects = $this->projectRepository->getAllPublished(6);
        $recentPosts = $this->postRepository->getRecentPublished(5);

        return view('home', compact('featuredProjects', 'projects', 'recentPosts'));
    }
}