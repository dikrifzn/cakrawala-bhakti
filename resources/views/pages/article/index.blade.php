@extends('layouts.app') 

@section('content')

<section class="py-20">
    <div class="text-start mb-10 max-w-6xl mx-auto px-4 sm:px-6">
        <p class="text-sm font-semibold tracking-wide mb-2 font-poppins">
            Our Articles
        </p>
        <h2 class="text-3xl font-bold font-poppins">Latest Blog & Articles</h2>
    </div>
    <div
        class="max-w-6xl mx-auto px-4 sm:px-6 grid sm:grid-cols-1 md:grid-rows-1 gap-6"
    >
        @for ($i = 0; $i < 5; $i++)
        <div
            class="flex flex-row bg-white shadow-sm rounded-lg p-4 hover:shadow-lg transition-shadow duration-300 cursor-pointer"
        >
            <div class="bg-gray-300 w-70 h-40 mb-4 rounded-md mr-3"></div>
            <div class="">
                <p class="text-gray-400 text-sm font-poppins">
                    October 13, 2025
                </p>
                <h4 class="font-semibold mt-2 font-poppins">
                    Latest Blog & Articles
                </h4>
                <p class="text-gray-500 text-sm mt-2 font-dmsans">
                    EO Jakarta kini menjadi kebutuhan utama bagi perusahaan...
                </p>
            </div>
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

@endsection
