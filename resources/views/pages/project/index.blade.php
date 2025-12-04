@extends('layouts.app')

@section('content')

<section id="publication" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-10">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">
            Recent Projects
        </p>
        <h2 class="text-3xl font-bold font-poppins mb-4">
            Proyek Terbaru Kami
        </h2>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-14">

        @forelse($projects as $project)
        <div>
            <h4 class="font-semibold mb-4 font-poppins">
                <a href="{{ route('project.show', $project) }}" class="text-slate-900 hover:text-yellow-500">{{ $project->project_title }}</a>
            </h4>

            <div class="swiper projectSwiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-3">

                            @if($project->images->count())
                                @foreach($project->images as $key => $image)
                                    <div class="mb-3 break-inside-avoid">
                                        @if($key == 0)
                                            <a href="{{ route('project.show', $project) }}">
                                                <img src="{{ asset('img/' . $image->image) }}" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                            </a>
                                        @else
                                            <img src="{{ asset('img/' . $image->image) }}" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-3">
                                    <a href="{{ route('project.show', $project) }}">
                                        <img src="{{ asset('img/' . ($project->cover_image ?? 'placeholder.jpg')) }}" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
                <div class="swiper-button-prev text-black"></div>
                <div class="swiper-button-next text-black"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        @empty
        <p class="text-gray-500">Belum ada proyek untuk ditampilkan.</p>
        @endforelse

    </div>
    <div class="flex space-x-1 justify-center mt-14">
        <button class="rounded-md border border-slate-300 py-2 px-3 text-sm text-slate-600 hover:bg-slate-800 hover:text-white">Prev</button>
        <button class="min-w-9 rounded-md bg-slate-800 py-2 px-3 text-sm text-white">1</button>
        <button class="min-w-9 rounded-md border border-slate-300 py-2 px-3 text-sm">...</button>
        <button class="min-w-9 rounded-md border border-slate-300 py-2 px-3 text-sm">5</button>
        <button class="min-w-9 rounded-md border border-slate-300 py-2 px-3 text-sm">Next</button>
    </div>
</section>
<script>
    new Swiper(".projectSwiper", {
        loop: true,
        speed: 600,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>

@endsection
