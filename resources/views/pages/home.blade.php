@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')

{{-- HERO SECTION --}}
@php
    $heroBg = ImageHelper::image($heroBanner?->background_image, 'placeholder-hero.jpg');
@endphp
<section class="relative w-full h-screen bg-cover bg-center" style="background-image: url('{{ $heroBg }}')">
    <div class="absolute inset-0 bg-black/70"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-48 text-white">
        <h1 class="text-4xl md:text-5xl font-bold leading-snug font-outfit" data-aos="fade-up">
            @if($heroBanner)
                @php
                    $title = $heroBanner->title;
                    $highlighted = $heroBanner->highlight_text;
                    if($highlighted) {
                        $title = str_replace($highlighted, '<span class="text-yellow-400">' . $highlighted . '</span>', $title);
                    }
                @endphp
                {!! $title !!}
            @else
                Kami Mewujudkan <br><span class="text-yellow-400">Acara Anda</span> Jadi Momen <br>Tak Terlupakan
            @endif
        </h1>

        <p class="mt-4 text-gray-200 max-w-xl font-dmsans" data-aos="fade-up" data-aos-delay="100">
            {{ $heroBanner?->subtitle ?? 'Event Organizer Profesional untuk Corporate, Wedding, dan Community Event.' }}
        </p>
<a data-aos="fade-up" data-aos-delay="200"a 
    @auth
        href="{{ url('/booking') }}"
    @else
        href="javascript:void(0)"
        onclick="openLoginModal()"
    @endauth
    class="inline-block mt-6 px-6 py-3 bg-yellow-400 text-black font-semibold rounded-md font-dmsans hover:bg-yellow-500 transition"
>
    {{ $heroBanner?->button_text ?? "Let's Collaborate" }}
</a>

    </div>
</section>

{{-- ABOUT SECTION --}}
@php
    $images = is_array($aboutSection?->images)
        ? array_values(array_filter($aboutSection->images))
        : [];
    $images = array_pad($images, 5, null);
@endphp
<section id="about" class="py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div
            class="grid grid-cols-2 gap-4"
            data-aos="fade-right"
            style="
                grid-template-rows: 160px 220px 110px;
                grid-template-areas:
                    'a d'
                    'c b'
                    'e b';
            "
        >
            <div style="grid-area: a" class="rounded-lg overflow-hidden bg-gray-200">
                <img src="{{ ImageHelper::image($images[0], 'default-thumbnail.png') }}" class="w-full h-full object-cover" alt="">
            </div>

            <div style="grid-area: b" class="rounded-lg overflow-hidden bg-gray-300">
                <img src="{{ ImageHelper::image($images[1], 'default-thumbnail.png') }}" class="w-full h-full object-cover" alt="">
            </div>

            <div style="grid-area: c" class="rounded-lg overflow-hidden bg-gray-200">
                <img src="{{ ImageHelper::image($images[2], 'default-thumbnail.png') }}" class="w-full h-full object-cover" alt="">
            </div>

            <div style="grid-area: d" class="rounded-lg overflow-hidden bg-gray-200">
                <img src="{{ ImageHelper::image($images[3], 'default-thumbnail.png') }}" class="w-full h-full object-cover" alt="">
            </div>

            <div style="grid-area: e" class="rounded-lg overflow-hidden bg-gray-200">
                <img src="{{ ImageHelper::image($images[4], 'default-thumbnail.png') }}" class="w-full h-full object-cover" alt="">
            </div>
        </div>

        <div data-aos="fade-left">
            <p class="text-sm font-semibold tracking-wide text-gray-800 mb-3 font-poppins">
                {{ $aboutSection?->title ?? 'About Cakrawala' }}
            </p>

            <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-6 font-poppins text-gray-900">
                {{ $aboutSection?->subtitle ?? 'Event Planner & <br>
                Organizer In Indonesia' }}
            </h2>

            <p class="text-gray-600 leading-relaxed max-w-xl font-dmsans">
                {{ $aboutSection?->description ??
                'Cakrawala adalah Event Organizer profesional yang berfokus pada menciptakan acara yang inspiratif dan berkesan. Kami percaya setiap acara memiliki cerita, dan tugas kami adalah memastikan cerita itu tersampaikan dengan sempurna.' }}
            </p>
        </div>

    </div>
</section>


{{-- WHY US SECTION --}}
@php
    $whyImagePath = $whyChooseUs?->image ?? null;
@endphp
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="flex flex-col justify-center" data-aos="fade-right">
            <h3 class="text-3xl font-bold mb-3 font-poppins">{{ $whyChooseUs?->title ?? 'Mengapa Cakrawala?' }}</h3>
            <div class="text-gray-600 mb-4 font-medium font-dmsans prose prose-sm max-w-none">
                {!! $whyChooseUs?->description ?? 'Kami menawarkan layanan yang fleksibel, detail, dan kreatif untuk memastikan acara Anda sempurna.' !!}
            </div>

            <a href="{{ url('/about') }}"
               class="inline-block w-fit px-6 mt-8 py-2.5 bg-yellow-400 text-black font-semibold rounded-md hover:bg-yellow-500 transition">
                Tentang Kami
            </a>
        </div>

        <div class="w-full aspect-square rounded-md overflow-hidden shadow" data-aos="fade-left">
            <img src="{{ ImageHelper::image($whyImagePath, 'default-thumbnail.png') }}" class="w-full h-full object-cover" alt="Why choose us">
        </div>
    </div>
</section>

{{-- SERVICE SECTION --}}
<section id="service" class="py-20">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6" data-aos="fade-up">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">Our Service</p>
        <h2 class="text-3xl font-bold mb-4 font-poppins">Layanan Kami</h2>
        <p class="text-gray-600 mb-10 font-dmsans font-medium">
            Kami menyediakan berbagai layanan penyelenggaraan acara, mulai dari perencanaan hingga pelaksanaan.
            Semua dirancang untuk memastikan pengalaman Anda berjalan lancar, berkesan, dan sukses.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative font-dmsans font-medium">
        <button type="button" aria-label="Prev" class="absolute -left-2 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-black shadow rounded-full w-9 h-9 grid place-items-center" onclick="document.getElementById('servicesScroller').scrollBy({ left: -800, behavior: 'smooth' })">‹</button>
        <button type="button" aria-label="Next" class="absolute -right-2 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-black shadow rounded-full w-9 h-9 grid place-items-center" onclick="document.getElementById('servicesScroller').scrollBy({ left: 800, behavior: 'smooth' })">›</button>

        <div id="servicesScroller" class="flex gap-0 overflow-x-auto snap-x snap-mandatory pb-0" style="scroll-behavior: smooth;">
        @php
            $services = $services ?? collect();
        @endphp
        @forelse($services as $service)
            <div class="group bg-white hover:bg-yellow-500 h-56 flex items-center justify-center 
                text-black font-semibold shadow-md hover:scale-105 transition-all duration-300 relative overflow-hidden min-w-[25%] shrink-0 snap-start" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="absolute inset-0" style="background-image: url('{{ ImageHelper::image($service->banner_image, 'default-thumbnail.png') }}'); background-size: cover; background-position: center;"></div>
                <div class="absolute inset-0 bg-white/70 group-hover:bg-yellow-500/60 transition-all"></div>
                <span class="relative z-10 text-lg md:text-xl">{{ $service->service_name }}</span>
            </div>
        @empty
            @foreach($events as $event)
                <div class="bg-white hover:bg-yellow-500 h-56 flex items-center justify-center 
                    text-black font-semibold shadow-md hover:scale-105 transition-all duration-300 min-w-[25%] shrink-0 snap-start">
                    <span class="text-lg md:text-xl">{{ $event->name }}</span>
                </div>
            @endforeach
        @endforelse
        </div>
        <style>
            #servicesScroller { -ms-overflow-style: none; scrollbar-width: none; }
            #servicesScroller::-webkit-scrollbar { display: none; }
        </style>
    </div>
</section>

{{-- PROJECT GALLERY SECTION --}}
<section id="publication" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-10" data-aos="fade-up">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">Recent Projects</p>
        <h2 class="text-3xl font-bold font-poppins mb-4">Proyek Terbaru Kami</h2>
        <p class="text-gray-500 max-w-xl text-sm font-dmsans font-medium">
            Sebuah festival komunitas yang menghadirkan ratusan pengunjung dan puluhan tenant lokal. Tim Cakrawala menangani seluruh perencanaan, koordinasi, hingga produksi acara agar berjalan lancar dan berkesan.
        </p>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
        @forelse($projects as $project)
            <h4 class="font-semibold mb-3 font-poppins">
                <a href="{{ route('project.show', $project) }}" class="hover:text-yellow-500">{{ $project->project_title }}</a>
            </h4>
            <div class="swiper projectSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-3">
                            @php
                                $images = is_array($project->images) ? $project->images : [];
                            @endphp
                            @if(count($images))
                                @foreach($images as $key => $imagePath)
                                    <div class="mb-3 break-inside-avoid">
                                        @if($key === 0)
                                            <a href="{{ route('project.show', $project) }}">
                                                <img src="{{ ImageHelper::image($imagePath, 'default-thumbnail.png') }}" loading="lazy" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                            </a>
                                        @else
                                            <img src="{{ ImageHelper::image($imagePath, 'default-thumbnail.png') }}" loading="lazy" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-3">
                                    <img src="{{ ImageHelper::image(null, 'default-thumbnail.png') }}" loading="lazy" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev text-black!"></div>
                <div class="swiper-button-next text-black!"></div>
                <div class="swiper-pagination"></div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada proyek untuk ditampilkan.</p>
        @endforelse
    </div>
    <div class="text-center mt-10">
        <a href="{{ url('/project') }}"
           class="inline-block px-6 py-2 bg-yellow-400 text-black rounded-md font-semibold font-dmsans">
           Lihat Lebih Banyak
        </a>
    </div>
</section>

{{-- CALL TO ACTION SECTION --}}
@php
    $ctaBg = ImageHelper::image($callToAction?->background_image, 'collab-bg.jpg');
@endphp
<section class="relative w-full h-[400px] bg-cover bg-center"
        style="background-image: url('{{ $ctaBg }}')">
    <div class="absolute inset-0 bg-black/70"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center text-white px-4 sm:px-6 py-32">
        <h2 class="text-2xl md:text-5xl font-bold font-outfit" data-aos="fade-up">
            @if($callToAction)
                @php
                    $ctaTitle = $callToAction->title;
                    $ctaHighlighted = $callToAction->highlight_text;
                    if($ctaHighlighted) {
                        $ctaTitle = str_replace($ctaHighlighted, '<span class="text-yellow-400">' . $ctaHighlighted . '</span>', $ctaTitle);
                    }
                @endphp
                {!! $ctaTitle !!}
            @else
                Let's Collaborate and Make <br><span class="text-yellow-400">Your Event Super Special</span>
            @endif
        </h2>
        <p class="mt-4 text-gray-300 font-dmsans font-medium" data-aos="fade-up" data-aos-delay="100">
            {{ $callToAction?->subtitle ?? 'Kami siap menjadi mitra terbaik Anda dalam setiap momen penting. Hubungi kami dan wujudkan acara impian Anda bersama Cakrawala.' }}
        </p>
    </div>
</section>

{{-- ARTICLES SECTION --}}
<section class="py-20">
    <div class="text-start mb-10 max-w-6xl mx-auto px-4 sm:px-6" data-aos="fade-up">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">Our Articles</p>
        <h2 class="text-3xl font-bold font-poppins">Latest Articles</h2>
        <p class="max-w-xl text-gray-500 text-sm font-dmsans font-medium mt-2">
            Temukan berbagai tips, inspirasi, dan cerita menarik seputar dunia event management. Dari ide konsep acara hingga tren dekorasi terbaru semua kami bagikan untuk membantu Anda menciptakan event terbaik.
        </p>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <div class="bg-white shadow-sm rounded-lg p-4 hover:shadow-lg transition-shadow duration-300 background-image: url(asset('{{ $article->thumbnail }}'))" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="bg-gray-300 h-48 mb-4 rounded-md" style="background-image: url('{{ ImageHelper::image($article->thumbnail, 'default-thumbnail.png') }}'); background-size: cover; background-position: center;"></div>
                                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs bg-yellow-200 text-black px-2 py-1 rounded">
                            {{ $article->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                <p class="text-gray-400 text-sm font-poppins">{{ $article->created_at->format('F d, Y') }}</p>
                <h4 class="font-semibold mt-2 font-poppins">{{ $article->title }}</h4>
                <p class="text-gray-500 text-sm mt-2 font-dmsans">
                    {{ Str::limit($article->content, 100) }}
                </p>
                <a href="{{ route('article.show', $article) }}" class="text-yellow-500 mt-3 inline-block font-dmsans">Read More →</a>
            </div>
        @empty
            <p class="text-gray-500 col-span-full">Belum ada artikel untuk ditampilkan.</p>
        @endforelse
    </div>

    <div class="text-center mt-10">
        <a href="{{ url('/article') }}"
           class="inline-block px-6 py-2 bg-yellow-400 text-black rounded-md font-semibold font-dmsans">
           Lihat Lebih Banyak
        </a>
    </div>
</section>

<script>
  var swiper = new Swiper(".projectSwiper", {
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    speed: 600,
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
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const nav = document.getElementById('navbar');
            nav.classList.remove('bg-black');
            nav.classList.add('bg-transparent');
    });

    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');

        if (window.scrollY > 30) {
            nav.classList.add('bg-black');
            nav.classList.remove('bg-transparent');
        } else {
            nav.classList.remove('bg-black');
            nav.classList.add('bg-transparent');
        }
    });
</script>

@endsection
