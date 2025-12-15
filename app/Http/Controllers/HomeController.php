<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Article;
use App\Models\EventType;
use App\Models\Service;
use App\Models\HeroBanner;
use App\Models\AboutSection;
use App\Models\WhyChooseUs;
use App\Models\CallToAction;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanner = HeroBanner::first();

        $aboutSection = AboutSection::first();
        $whyChooseUs = WhyChooseUs::first();
        $callToAction = CallToAction::first();

        $siteSetting = SiteSetting::first();
        $pageTitle = $siteSetting->site_name ?? 'Cakrawala Event Organizer';

        $projects = Project::select('id', 'project_title', 'date', 'images')
            ->orderByDesc('date')
            ->limit(2)
            ->get()
            ->map(function ($project) {
                if (is_array($project->images)) {
                    $project->images = array_slice($project->images, 0, 10);
                }
                return $project;
            });

        $articles = Article::select('id', 'title', 'slug', 'thumbnail', 'created_at', 'category_id')
            ->with(['category' => function ($query) {
                $query->select('id', 'name');
            }])
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $events = EventType::select('id', 'name')->get();

        $services = Service::select('id', 'service_name', 'short_description', 'price', 'banner_image', 'sort_order')
            ->adminServices()
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('pages.home', compact(
            'heroBanner',
            'aboutSection',
            'whyChooseUs',
            'callToAction',
            'projects',
            'articles',
            'events',
            'services',
            'pageTitle'
        ));
    }
}
