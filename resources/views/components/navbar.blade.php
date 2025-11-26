<nav
    id="navbar"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-black backdrop-blur-md font-poppins font-semibold"
>
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
        <div class="flex items-center gap-2">
            <img src="/img/logo-white.png" alt="logo" class="h-6" />
        </div>
        <div class="hidden md:flex items-center gap-8 text-white text-sm">
            <a href="{{ url('/') }}" class="hover:text-yellow-400">Home</a>
            <a href="{{ url('/#about') }}" class="hover:text-yellow-400"
                >About</a
            >
            <a href="{{ url('/#service') }}" class="hover:text-yellow-400"
                >Service</a
            >
            <a href="{{ url('/#publication') }}" class="hover:text-yellow-400"
                >Publication</a
            >

            <button
                onclick="openLoginModal()"
                class="px-4 py-2 bg-yellow-400 text-black rounded-md font-semibold hover:bg-yellow-300"
            >
                Masuk
            </button>
        </div>
        {{-- Mobile --}}
        <button id="mobile-btn" class="md:hidden text-white text-2xl">
            &#9776;
        </button>
    </div>

    {{-- Mobile menu --}}
    <div
        id="mobile-menu"
        class="hidden md:hidden bg-black/90 text-white px-6 py-4 space-y-4"
    >
        <a href="{{ url('/') }}" class="block">Home</a>
        <a href="{{ url('/#about') }}" class="block">About</a>
        <a href="{{ url('/#service') }}" class="block">Service</a>
        <a href="{{ url('/#publication') }}" class="block">Publication</a>

        <button
            onclick="openLoginModal()"
            class="px-4 py-2 bg-yellow-400 text-black rounded-md font-semibold hover:bg-yellow-300"
        >
            Masuk
        </button>
    </div>
</nav>
<script>
    document.getElementById("mobile-btn").addEventListener("click", () => {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>

@include('components.login-modal') @include('components.register-modal')
