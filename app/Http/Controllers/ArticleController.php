<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')
            ->latest()
            ->paginate(12);

        $categories = ArticleCategory::withCount('articles')->get();

        return view('pages.article.index', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
    public function show(Article $article)
    {
        // $article is route-model-bound by slug (see Article::getRouteKeyName)
        $article->load('category');

        $relatedArticles = Cache::remember("article:{$article->slug}:related", 3600, function () use ($article) {
            return Article::where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->latest()
                ->take(3)
                ->get();
        });

        return view('pages.article.detail', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
    public function byCategory($categorySlug)
    {
        $category = ArticleCategory::bySlug($categorySlug)->firstOrFail();

        $articles = Article::with('category')
            ->byCategory($category->id)
            ->latest()
            ->paginate(12);

        $categories = ArticleCategory::withCount('articles')->get();

        return view('pages.article.index', [
            'articles' => $articles,
            'categories' => $categories,
            'activeCategory' => $category,
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $articles = Article::with('category')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(12);

        $categories = ArticleCategory::withCount('articles')->get();

        return view('pages.article.index', [
            'articles' => $articles,
            'categories' => $categories,
            'searchQuery' => $query,
        ]);
    }
}
