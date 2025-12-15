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
        $projects = Project::select('id', 'project_title', 'client_name', 'location', 'date', 'images')
            ->orderByDesc('date')
            ->paginate(6);

        $projects->getCollection()->transform(function ($project) {
            if (is_array($project->images)) {
                $project->images = array_slice($project->images, 0, 10);
            }
            return $project;
        });
        
        return view('pages.project.index', compact('projects'));
    }

    /**
     * Display a single project detail.
     */
    public function show(Project $project)
    {
        return view('pages.project.detail', compact('project'));
    }
}
