@extends('layouts.app')

@section('content')

<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-10">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">
            Detail Gallery
        </p>
        <h2 class="text-3xl font-bold font-poppins mb-4">
            Acara Super Festival di Kuningan
        </h2>
    </div>
    <div id="gallery" class="max-w-6xl mx-auto px-4 sm:px-6 columns-2 sm:columns-3 md:columns-4 gap-4">

        @forelse($project->images as $image)
            @php
                $full = asset('img/' . $image->image);
                $thumb = $full;
            @endphp

            <a 
                href="{{ $full }}"
                data-pswp-width="1600"
                data-pswp-height="1000"
                data-cropped="true"
                class="block mb-4 break-inside-avoid overflow-hidden rounded-xl group"
            >
                <img 
                    src="{{ $thumb }}" 
                    class="w-full rounded-xl transition duration-300 group-hover:scale-110"
                    alt="{{ $project->project_title }}"
                >
            </a>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">Belum ada gambar untuk project ini.</div>
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
