<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Load minimal data to improve performance
        $projects = Project::select('id', 'project_title', 'date')
            ->with(['images' => function ($query) {
                $query->select('id', 'project_id', 'image');
            }])
            ->orderByDesc('date')
            ->limit(2)
            ->get();

        $articles = Article::select('id', 'title', 'slug', 'thumbnail', 'created_at', 'category_id')
            ->with(['category' => function ($query) {
                $query->select('id', 'name');
            }])
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('pages.home', compact('projects', 'articles'));
    }
}
