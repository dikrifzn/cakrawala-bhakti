<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Article;
use App\Models\EventType;
use App\Models\HeroBanner;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Load hero banner data from database
        $heroBanner = HeroBanner::first();

        // Site settings for page title and other meta
        $siteSetting = SiteSetting::first();
        $pageTitle = $siteSetting->site_name ?? 'Cakrawala Event Organizer';

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

        $events = EventType::select('id', 'name')->get();

        return view('pages.home', compact('heroBanner', 'projects', 'articles', 'events', 'pageTitle'));
    }
}
