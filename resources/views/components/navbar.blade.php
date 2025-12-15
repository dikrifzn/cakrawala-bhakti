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
                >Tentang</a
            >
            <a href="{{ url('/#service') }}" class="hover:text-yellow-400"
                >Layanan</a
            >
            <a href="{{ url('/project') }}" class="hover:text-yellow-400"
                >Projek</a
            >
            <a href="{{ url('/article') }}" class="hover:text-yellow-400"
                >Artikel</a
            >
<a 
    @auth
        href="{{ url('/booking') }}"
    @else
        href="javascript:void(0)" 
        onclick="openLoginModal()"
    @endauth
    class="block"
>
    Pesan
</a>

            @auth
                <div class="relative group">
                    <button class="flex items-center gap-3 hover:opacity-90 transition cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-linear-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-white font-bold shadow-md">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                            <p class="text-gray-300 text-xs">Lihat Profil</p>
                        </div>
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>

                    {{-- Dropdown menu --}}
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-t-lg border-b">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Edit Profil
                            </div>
                        </a>
                        <a href="{{ route('profile.bookings') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 border-b">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Pesanan Saya
                            </div>
                        </a>
                        <form method="POST" action="{{ route('customer.logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-500 hover:bg-gray-100 rounded-b-lg font-semibold flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <button
                    onclick="openLoginModal()"
                    class="px-4 py-2 bg-yellow-400 text-black rounded-md font-semibold hover:bg-yellow-300 cursor-pointer"
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
        <a href="{{ url('/#about') }}" class="block">Tentang</a>
        <a href="{{ url('/#service') }}" class="block">Layanan</a>
        <a href="{{ url('/project') }}" class="block">Projek</a>
        <a href="{{ url('/article') }}" class="block">Artikel</a>
<a 
    @auth
        href="{{ url('/booking') }}"
    @else
        href="javascript:void(0)" 
        onclick="openLoginModal()"
    @endauth
    class="block"
>
    Pesan
</a>


        @auth
            <div class="border-t border-gray-700 pt-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-linear-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-yellow-400 font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-gray-400 text-xs">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-2 mb-4">
                    <a href="{{ route('profile.edit') }}" class="px-3 py-2 rounded-md text-sm text-gray-200 hover:bg-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Edit Profil
                    </a>
                    <a href="{{ route('profile.bookings') }}" class="px-3 py-2 rounded-md text-sm text-gray-200 hover:bg-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Pesanan Saya
                    </a>
                </div>
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 font-semibold flex items-center gap-2 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Keluar
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
