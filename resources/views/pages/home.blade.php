@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<section class="relative w-full h-[90vh] bg-cover bg-center" style="background-image: url('/img/hero-bg.jpg')">
    <div class="absolute inset-0 bg-black/70"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-48 text-white">
        <h1 class="text-4xl md:text-5xl font-bold leading-snug font-outfit">
            Kami Mewujudkan <br>
            <span class="text-yellow-400">Acara Anda</span> Jadi Momen <br>
            Tak Terlupakan
        </h1>

        <p class="mt-4 text-gray-200 max-w-xl font-dmsans">
            Event Organizer Profesional untuk Corporate, Wedding, dan Community Event.
        </p>
<a 
    @auth
        href="{{ url('/booking') }}"
    @else
        href="javascript:void(0)"
        onclick="openLoginModal()"
    @endauth
    class="inline-block mt-6 px-6 py-3 bg-yellow-400 text-black font-semibold rounded-md font-dmsans hover:bg-yellow-500 transition"
>
    Let’s Collaborate
</a>

    </div>
</section>

{{-- ABOUT SECTION --}}
<section id="about" class="py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="grid grid-cols-2 gap-4">
            <div class="grid grid-rows-3 gap-4">
                <div class="bg-gray-300 h-40 rounded-md hover:opacity-90 transition"></div>
                <div class="bg-gray-300 h-32 rounded-md hover:opacity-90 transition"></div>
                <div class="bg-gray-300 h-24 rounded-md hover:opacity-90 transition"></div>
            </div>
            <div class="grid grid-rows-2 gap-4">
                <div class="bg-gray-300 h-32 rounded-md hover:opacity-90 transition"></div>
                <div class="bg-gray-300 h-52 rounded-md hover:opacity-90 transition"></div>
            </div>
        </div>

        <div class="flex flex-col justify-center">
            <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">About Cakrawala</p>

            <h2 class="text-3xl md:text-4xl font-bold leading-tight mb-4 font-poppins">
                Event Planner & Organizer <br class="hidden md:block">
                In Indonesia
            </h2>

            <p class="text-gray-600 leading-relaxed mb-6 font-dmsans font-medium">
                Cakrawala adalah Event Organizer profesional yang berfokus pada menciptakan acara yang inspiratif dan berkesan. Kami percaya setiap acara memiliki cerita, dan tugas kami adalah memastikan cerita itu tersampaikan dengan sempurna. Dengan tim kreatif yang berpengalaman, kami menangani berbagai jenis event mulai dari corporate gathering, wedding, hingga festival komunitas dengan perencanaan yang matang dan hasil yang memuaskan.
            </p>
        </div>
    </div>
</section>

{{-- WHY US SECTION --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="flex flex-col justify-center">
            <h3 class="text-3xl font-bold mb-3 font-poppins">Mengapa Cakrawala?</h3>
            <p class="text-gray-600 mb-4 font-medium font-dmsans">
                Kami memahami bahwa setiap klien memiliki kebutuhan yang berbeda. Karena itu, kami menawarkan layanan yang fleksibel, detail, dan kreatif untuk memastikan setiap acara berjalan sempurna dari awal hingga akhir.
            </p>

            <ul class="space-y-3 text-gray-700 font-medium font-dmsans">
                <li>✔ Perencanaan yang Tepat & Terukur</li>
                <li>✔ Tim Kreatif & Berpengalaman</li>
                <li>✔ Konsep Unik Sesuai Kebutuhan Klien</li>
                <li>✔ Manajemen Acara yang Profesional</li>
            </ul>

            <a href="{{ url('/about') }}"
               class="inline-block w-fit px-6 mt-8 py-2.5 bg-yellow-400 text-black font-semibold rounded-md hover:bg-yellow-500 transition">
                About Us
            </a>
        </div>

        <div class="bg-gray-300 h-72 sm:h-96 md:h-full rounded-md"></div>
    </div>
</section>

{{-- SERVICE SECTION --}}
<section id="service" class="py-20">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">Our Service</p>
        <h2 class="text-3xl font-bold mb-4 font-poppins">Layanan Kami</h2>
        <p class="text-gray-600 mb-10 font-dmsans font-medium">
            Kami menyediakan berbagai layanan penyelenggaraan acara, mulai dari perencanaan hingga pelaksanaan.
            Semua dirancang untuk memastikan pengalaman Anda berjalan lancar, berkesan, dan sukses.
        </p>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 font-dmsans font-medium">
        @foreach($events as $event)
            <div class="bg-white hover:bg-yellow-500 h-48 rounded-xl flex items-center justify-center 
                text-black font-semibold shadow-md hover:scale-105 transition-all duration-300 cursor-pointer">
                {{ $event->name }} →
            </div>
        @endforeach
    </div>
</section>

{{-- PROJECT GALLERY SECTION --}}
<section id="publication" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-10">
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
                            @if($project->images->count())
                                @foreach($project->images as $imageRecord)
                                    @php
                                        $images = is_array($imageRecord->image) ? $imageRecord->image : [$imageRecord->image];
                                    @endphp
                                    @foreach($images as $key => $imagePath)
                                        <div class="mb-3 break-inside-avoid">
                                            @if($key == 0)
                                                <a href="{{ route('project.show', $project) }}">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" loading="lazy" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $imagePath) }}" loading="lazy" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            @else
                                <div class="mb-3">
                                    <img src="{{ asset('img/' . ($project->cover_image ?? 'placeholder.jpg')) }}" loading="lazy" class="w-full rounded-lg shadow-sm object-cover h-40" alt="{{ $project->project_title }}">
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
<section class="relative w-full h-[400px] bg-cover bg-center"
        style="background-image: url('/img/collab-bg.jpg')">
    <div class="absolute inset-0 bg-black/70"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center text-white px-4 sm:px-6 py-32">
        <h2 class="text-2xl md:text-5xl font-bold font-outfit">
            Let's Collaborate and Make <br>
            <span class="text-yellow-400">Your Event Super Special</span>
        </h2>
        <p class="mt-4 text-gray-300 font-dmsans font-medium">
            Kami siap menjadi mitra terbaik Anda dalam setiap momen penting. Hubungi kami dan wujudkan acara impian Anda bersama Cakrawala.
        </p>
    </div>
</section>

{{-- ARTICLES SECTION --}}
<section class="py-20">
    <div class="text-start mb-10 max-w-6xl mx-auto px-4 sm:px-6">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">Our Articles</p>
        <h2 class="text-3xl font-bold font-poppins">Latest Articles</h2>
        <p class="max-w-xl text-gray-500 text-sm font-dmsans font-medium mt-2">
            Sebuah festival komunitas yang menghadirkan ratusan pengunjung dan puluhan tenant lokal. Tim Cakrawala menangani seluruh perencanaan, koordinasi, hingga produksi acara agar berjalan lancar dan berkesan.
        </p>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <div class="bg-white shadow-sm rounded-lg p-4 hover:shadow-lg transition-shadow duration-300 background-image: url(asset('{{ $article->thumnail }}'))">
                <div class="bg-gray-300 h-48 mb-4 rounded-md" style="background-image: url('{{ asset('storage/' . $article->thumbnail) }}'); background-size: cover; background-position: center;"></div>
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
