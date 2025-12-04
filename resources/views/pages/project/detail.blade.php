@extends('layouts.app')

@section('content')

<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-10">
        <a href="{{ route('project.index') }}" class="text-black hover:text-yellow-500 mb-4 inline-block">
            ← Kembali ke Proyek
        </a>
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">
            Detail Proyek
        </p>
        <h2 class="text-3xl font-bold font-poppins mb-2">
            {{ $project->project_title }}
        </h2>
        <div class="text-gray-600 text-sm mb-4">
            <p><strong>Client:</strong> {{ $project->client_name ?? 'N/A' }}</p>
            <p><strong>Lokasi:</strong> {{ $project->location ?? 'N/A' }}</p>
            <p><strong>Tanggal:</strong> {{ $project->date ? $project->date->format('F d, Y') : 'N/A' }}</p>
        </div>
    </div>    
    @if($project->description)
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-12 prose prose-lg">
            {!! $project->description !!}
        </div>
    @endif

    <div id="gallery" class="max-w-6xl mx-auto px-4 sm:px-6 columns-2 sm:columns-3 md:columns-4 gap-4">
        @forelse($project->images as $image)
            <a 
                href="{{ asset('img/' . $image->image) }}"
                data-pswp-width="1600"
                data-pswp-height="1000"
                data-cropped="true"
                class="block mb-4 break-inside-avoid overflow-hidden rounded-xl group"
            >
                <img 
                    src="{{ asset('img/' . $image->image) }}"
                    loading="lazy"
                    class="w-full rounded-xl transition duration-300 group-hover:scale-110"
                    alt="{{ $project->project_title }}"
                >
            </a>
        @empty
            <p class="text-gray-500">Tidak ada gambar untuk proyek ini.</p>
        @endforelse
    </div>
</section>

@once
    <link rel="stylesheet" href="https://unpkg.com/photoswipe@5/dist/photoswipe.css">

    <script type="module">
        import PhotoSwipeLightbox from "https://unpkg.com/photoswipe@5/dist/photoswipe-lightbox.esm.min.js";
        import PhotoSwipe from "https://unpkg.com/photoswipe@5/dist/photoswipe.esm.min.js";

        const lightbox = new PhotoSwipeLightbox({
            gallery: '#gallery',
            children: 'a',
            pswpModule: PhotoSwipe,

            showHideOpacity: true,
            bgOpacity: 0.9,
            zoom: true,

            wheelToZoom: true,
            padding: { top: 20, bottom: 20, left: 20, right: 20 },
        });

        lightbox.init();
    </script>
@endonce

@endsection
