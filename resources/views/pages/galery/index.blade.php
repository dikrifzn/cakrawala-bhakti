@extends('layouts.app')

@section('content')

<section id="publication" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-10">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">
            Recent Project Gallery
        </p>
        <h2 class="text-3xl font-bold font-poppins mb-4">
            Proyek Terbaru Kami
        </h2>
    </div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
        @for ($p = 1; $p <= 5; $p++)
        <h4 class="font-semibold mb-3 font-poppins">
            Acara Super Festival di Kuningan
        </h4>
        <div class="swiper projectSwiper">
            <div class="swiper-wrapper">
                @for ($i = 0; $i < 3; $i++)
                <div class="swiper-slide">
                    <div class="grid grid-cols-6 gap-3">
                        <div
                            class="col-span-2 bg-gray-300 h-40 rounded-md"
                        ></div>
                        <div
                            class="col-span-1 bg-gray-300 h-20 rounded-md"
                        ></div>
                        <div
                            class="col-span-3 bg-gray-300 h-48 rounded-md"
                        ></div>
                        <div
                            class="col-span-2 bg-gray-300 h-28 rounded-md"
                        ></div>
                        <div
                            class="col-span-1 bg-gray-300 h-28 rounded-md"
                        ></div>
                        <div
                            class="col-span-1 bg-gray-300 h-40 rounded-md"
                        ></div>
                        <div
                            class="col-span-2 bg-gray-300 h-32 rounded-md"
                        ></div>
                        <div
                            class="col-span-2 bg-gray-300 h-32 rounded-md"
                        ></div>
                        <div
                            class="col-span-2 bg-gray-300 h-32 rounded-md"
                        ></div>
                        <div
                            class="col-span-2 bg-gray-300 h-32 rounded-md"
                        ></div>
                    </div>
                </div>
                @endfor
            </div>
            <div class="swiper-button-prev !text-black"></div>
            <div class="swiper-button-next !text-black"></div>
            <div class="swiper-pagination"></div>
        </div>
        @endfor
    </div>
    <div class="flex space-x-1 justify-center mt-10">
        <button
            class="rounded-md border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2 cursor-pointer"
        >
            Prev
        </button>
        <button
            class="min-w-9 rounded-md bg-slate-800 py-2 px-3 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2 cursor-pointer"
        >
            1
        </button>
        <button
            class="min-w-9 rounded-md border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2"
        >
            ...
        </button>
        <button
            class="min-w-9 rounded-md border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2 cursor-pointer"
        >
            5
        </button>
        <button
            class="min-w-9 rounded-md border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2 cursor-pointer"
        >
            Next
        </button>
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

@endsection
