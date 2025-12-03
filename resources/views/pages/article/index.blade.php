@extends('layouts.app') 

@section('content')

<section class="py-20">
    <div class="text-start mb-10 max-w-6xl mx-auto px-4 sm:px-6">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">
            Our Articles
        </p>
        <h2 class="text-3xl font-bold font-poppins">
            @if(isset($searchQuery))
                Hasil Pencarian: "{{ $searchQuery }}"
            @elseif(isset($activeCategory))
                {{ $activeCategory->name }}
            @else
                Latest Articles
            @endif
        </h2>
    </div>

    <!-- Search Bar -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-8">
        <form action="{{ route('article.search') }}" method="GET" class="flex gap-2">
            <input 
                type="text" 
                name="q" 
                placeholder="Cari artikel..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                value="{{ $searchQuery ?? '' }}"
            >
            <button type="submit" class="px-6 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 cursor-pointer">
                Cari
            </button>
        </form>
    </div>

    <!-- Categories Filter -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-8">
        <div class="flex gap-2 overflow-x-auto pb-2">
            <a href="{{ route('article.index') }}" 
               class="px-4 py-2 rounded-full whitespace-nowrap {{ !isset($activeCategory) ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua
            </a>
            @foreach($categories as $category)
                <a href="{{ route('article.category', $category->slug) }}" 
                   class="px-4 py-2 rounded-full whitespace-nowrap {{ (isset($activeCategory) && $activeCategory->id === $category->id) ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $category->name }} ({{ $category->articles_count }})
                </a>
            @endforeach
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <a href="{{ route('article.show', $article->slug) }}" 
               class="bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-video bg-gray-300 overflow-hidden">
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-linear-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs bg-yellow-200 text-black px-2 py-1 rounded">
                            {{ $article->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm font-poppins">
                        {{ $article->created_at->format('F d, Y') }}
                    </p>
                    <h4 class="font-semibold mt-2 font-poppins line-clamp-2">
                        {{ $article->title }}
                    </h4>
                    <p class="text-gray-500 text-sm mt-2 font-dmsans line-clamp-2">
                        {{ strip_tags($article->content) }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Tidak ada artikel yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-12">
            {{ $articles->links() }}
        </div>
    @endif
</section>

@endsection
