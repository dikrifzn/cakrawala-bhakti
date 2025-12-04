<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects with pagination.
     */
    public function index()
    {
        $projects = Project::select('id', 'project_title', 'date')
            ->with(['images' => function ($query) {
                $query->select('id', 'project_id', 'image');
            }])
            ->orderByDesc('date')
            ->paginate(6);
        
        return view('pages.project.index', compact('projects'));
    }

    /**
     * Display a single project detail.
     */
    public function show(Project $project)
    {
        $project->load('images');
        return view('pages.project.detail', compact('project'));
    }
}
