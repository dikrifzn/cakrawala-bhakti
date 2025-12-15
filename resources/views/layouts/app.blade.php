<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="icon" type="image/x-icon" href="/img/single-logo.png">
    <title>{{ $pageTitle ?? 'Cakrawala Event Organizer' }}</title>
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });
        });
    </script>
    @include('components.navbar')

    <main>
        {{-- Global Alert pojok kanan atas, auto-dismiss --}}
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" class="fixed top-6 right-6 z-50 flex flex-col gap-2 items-end">
            @if(session('success'))
                <div x-show="show" x-transition class="bg-green-50 border border-green-200 rounded-lg px-6 py-3 flex items-center gap-3 shadow-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-700">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div x-show="show" x-transition class="bg-red-50 border border-red-200 rounded-lg px-6 py-3 flex items-center gap-3 shadow-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-red-700">{{ session('error') }}</span>
                </div>
            @endif
        </div>
        @yield('content')
        @stack('scripts')
    </main>

    @include('components.footer')
</body>
</html>
