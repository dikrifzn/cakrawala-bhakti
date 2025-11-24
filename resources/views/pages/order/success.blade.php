@extends('layouts.app')

@section('content')
<section class="py-20 bg-[#F5C542] text-white h-[100vh] flex items-center">
    <div class="flex flex-col items-center text-center px-6 w-full relative">

        <!-- Confetti Background (menggunakan gambar upload) -->
        <img 
            src="{{ url('img/confetti.png') }}"
            alt="confetti"
            class="pointer-events-none
                   absolute left-[64%] top-[85%] -translate-x-1/2 -translate-y-1/2
                   opacity-95 z-0 animate-[slowSpin_6s_ease-in-out_infinite]"
        >

        <!-- Success icon -->
        <img 
            src="{{ url('img/success.png') }}" 
            alt="success" 
            class="w-44 md:w-56 relative z-10 mb-6"
        >

        <h2 class="text-4xl font-bold mb-2 font-poppins z-10">
            THANK YOU
        </h2>

        <p class="text-lg font-medium font-poppins z-10">
            PESANANMU TELAH TERKONFIRMASI
        </p>

        <p class="mt-2 font-dmsans text-white z-10">
            Kami akan segera menghubungi email konfirmasi ke 
            <span class="font-semibold">example@gmail.com</span>
        </p>

    </div>
</section>

<style>
@keyframes slowSpin {
    0% { transform: translate(-50%, -50%) rotate(0deg) scale(1); }
    50% { transform: translate(-50%, -50%) rotate(10deg) scale(1.1); }
    100% { transform: translate(-50%, -50%) rotate(0deg) scale(1); }
}
</style>
@endsection
