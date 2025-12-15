@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
@endphp

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
        <div class="group transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
            <h4 class="font-semibold mb-4 font-poppins">
                <a href="{{ route('project.show', $project) }}" class="hover:text-yellow-500 transition">{{ $project->project_title }}</a>
            </h4>

            <div class="swiper projectSwiper opacity-100 group-hover:opacity-90 transition-opacity duration-300">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-3">
                            @php
                                $images = is_array($project->images) ? $project->images : [];
                            @endphp
                            @if(count($images))
                                @foreach($images as $key => $imagePath)
                                    <div class="mb-3 break-inside-avoid overflow-hidden rounded-lg group/img">
                                        @if($key === 0)
                                            <a href="{{ route('project.show', $project) }}">
                                                <img src="{{ ImageHelper::image($imagePath, 'default-thumbnail.png') }}"
                                                     loading="lazy" 
                                                     class="w-full shadow-sm object-cover h-40 group-hover/img:scale-110 transition-transform duration-300" 
                                                     alt="{{ $project->project_title }}">
                                            </a>
                                        @else
                                            <img src="{{ ImageHelper::image($imagePath, 'default-thumbnail.png') }}" 
                                                 loading="lazy" 
                                                 class="w-full shadow-sm object-cover h-40 group-hover/img:scale-110 transition-transform duration-300" 
                                                 alt="{{ $project->project_title }}">
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-3 overflow-hidden rounded-lg group/img">
                                    <img src="{{ ImageHelper::image(null, 'default-thumbnail.png') }}" 
                                         loading="lazy" 
                                         class="w-full shadow-sm object-cover h-40 group-hover/img:scale-110 transition-transform duration-300" 
                                         alt="{{ $project->project_title }}">
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
    
    <!-- Pagination -->
    @if($projects->hasPages())
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-14">
            {{ $projects->onEachSide(1)->links('components.pagination') }}
        </div>
    @endif
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
