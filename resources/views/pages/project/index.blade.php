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

        @for ($p = 1; $p <= 5; $p++)
        <div>
            <h4 class="font-semibold mb-4 font-poppins">
                Acara Super Festival di Kuningan
            </h4>
            <div class="swiper projectSwiper">
                <div class="swiper-wrapper">

                    @for ($slide = 1; $slide <= 3; $slide++)
                    <div class="swiper-slide">
                        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-3">

                            @for ($i = 1; $i <= 15; $i++)
                            <div class="mb-3 break-inside-avoid">
                                <img 
                                    src="https://picsum.photos/{{ rand(400,900) }}?sig={{ $p.$slide.$i }}" 
                                    class="w-full rounded-lg shadow-sm"
                                    alt="Gallery Image">
                            </div>
                            @endfor
                        </div>
                    </div>
                    @endfor

                </div>
                <div class="swiper-button-prev text-black"></div>
                <div class="swiper-button-next text-black"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        @endfor

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
