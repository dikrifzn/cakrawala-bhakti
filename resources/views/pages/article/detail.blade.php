@extends('layouts.app') @section('content')

<section class="py-20 flex flex-col justify-center items-center m-5">
    <div class="max-w-[850px] mt-3">
        <a href="{{ route('article.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            ← Kembali ke Artikel
        </a>
        
        <h1 class="text-4xl md:text-5xl font-bold leading-snug font-outfit">
            {{ $article->title }}
        </h1>
        
        <div class="flex items-center gap-4 mb-5 mt-4">
            <span class="text-gray-400 text-sm font-poppins">
                {{ $article->created_at ? $article->created_at->format('F d, Y') : '' }}
            </span>
            @if($article->category)
                <span class="text-xs bg-yellow-200 text-black px-3 py-1 rounded">
                    {{ $article->category->name }}
                </span>
            @endif
        </div>

        @if($article->thumbnail)
            <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                 alt="{{ $article->title }}" 
                 class="w-full h-96 object-cover rounded-lg" />
        @else
            <div class="w-full h-96 bg-gray-300 rounded-lg flex items-center justify-center">
                <span class="text-gray-500">No Image</span>
            </div>
        @endif

        <div class="mt-8 prose prose-lg max-w-none">
            {!! $article->content !!}
        </div>
    </div>

    @if($relatedArticles->isNotEmpty())
        <div class="mt-12 w-full">
            <div class="text-start mb-10 max-w-6xl mx-auto px-4 sm:px-6">
                <h3 class="text-2xl font-bold font-poppins">Artikel Terkait</h3>
            </div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($relatedArticles as $relatedArticle)
                    <a href="{{ route('article.show', $relatedArticle->slug) }}"
                       class="bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-video bg-gray-300 overflow-hidden">
                            @if($relatedArticle->thumbnail)
                                <img src="{{ asset('storage/' . $relatedArticle->thumbnail) }}" 
                                     alt="{{ $relatedArticle->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="text-gray-400 text-sm font-poppins">
                                {{ $relatedArticle->created_at ? $relatedArticle->created_at->format('F d, Y') : '' }}
                            </p>
                            <h4 class="font-semibold mt-2 font-poppins line-clamp-2">
                                {{ $relatedArticle->title }}
                            </h4>
                            <p class="text-gray-500 text-sm mt-2 font-dmsans line-clamp-2">
                                {{ strip_tags($relatedArticle->content) }}
                            </p>
                            <span class="text-yellow-500 mt-3 inline-block font-dmsans hover:text-yellow-600">
                                Baca Selengkapnya →
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

@endsection

