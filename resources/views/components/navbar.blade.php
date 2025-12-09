<nav
    id="navbar"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-black backdrop-blur-md font-poppins font-semibold"
>
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
        <div class="flex items-center gap-2">
            <a href="{{ url('/') }}"><img src="/img/logo-white.png" alt="logo" class="h-6" /></a>
        </div>
        <div class="hidden md:flex items-center gap-8 text-white text-sm">
            <a href="{{ url('/') }}" class="hover:text-yellow-400">Home</a>
            <a href="{{ url('/#about') }}" class="hover:text-yellow-400"
                >About</a
            >
            <a href="{{ url('/#service') }}" class="hover:text-yellow-400"
                >Service</a
            >
            <a href="{{ url('/project') }}" class="hover:text-yellow-400"
                >Project</a
            >
            <a href="{{ url('/article') }}" class="hover:text-yellow-400"
                >Article</a
            >
            <a href="{{ url('/booking') }}" class="hover:text-yellow-400"
                >Booking</a
            >

            @auth
                <div class="flex items-center gap-3">
                    <span class="text-yellow-400">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded-md text-xs hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <button
                    onclick="openLoginModal()"
                    class="px-4 py-2 bg-yellow-400 text-black rounded-md font-semibold hover:bg-yellow-300"
                >
                    Masuk
                </button>
            @endauth
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
        <a href="{{ url('/project') }}" class="block">Project</a>
        <a href="{{ url('/article') }}" class="block">Article</a>
        <a href="{{ url('/booking') }}" class="block">Booking</a>

        @auth
            <div class="border-t border-gray-700 pt-4">
                <p class="text-yellow-400 font-semibold mb-3">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>
        @else
            <button
                onclick="openLoginModal()"
                class="w-full px-4 py-2 bg-yellow-400 text-black rounded-md font-semibold hover:bg-yellow-300"
            >
                Masuk
            </button>
        @endauth
    </div>
</nav>
<script>
    document.getElementById("mobile-btn").addEventListener("click", () => {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>

@include('components.login-modal') @include('components.register-modal')
