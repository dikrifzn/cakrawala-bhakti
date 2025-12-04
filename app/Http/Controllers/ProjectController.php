<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects with images.
     */
    public function index()
    {
        $projects = Project::with('images')->orderByDesc('date')->get();
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
