<footer class="bg-black text-gray-300 pt-16 pb-6 font-dmsans">
    @php
        use App\Helpers\ImageHelper;
        $siteSetting = \App\Models\SiteSetting::first();
    @endphp
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12">
        <div>
            <img src="{{ ImageHelper::image($siteSetting?->logo_footer, 'logo-white.png') }}" class="h-10 mb-4" />
            <p class="text-sm leading-relaxed mb-4 font-poppins font-light">
                <span class="font-semibold text-xl">{{ $siteSetting?->tagline ?? 'Cakrawala Event Organizer' }}</span>
                <br/>{{ $siteSetting?->footer_description ?? 'Kami membantu Anda menciptakan acara berkesanmulai dari konsep, perencanaan, hingga pelaksanaan. Bersama Cakrawala, setiap momen menjadi istimewa.' }}
            </p>
            <div class="flex items-center gap-4 text-xl mt-6">
                @if($siteSetting?->instagram)
                    <a href="{{ $siteSetting->instagram }}" class="hover:text-yellow-400 transition" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
                @if($siteSetting?->facebook)
                    <a href="{{ $siteSetting->facebook }}" class="hover:text-yellow-400 transition" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                @endif
                @if($siteSetting?->tiktok)
                    <a href="{{ $siteSetting->tiktok }}" class="hover:text-yellow-400 transition" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                @endif
            </div>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4 font-poppins">
                Quick Links
            </h4>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="/" class="hover:text-yellow-400 transition">Home</a>
                </li>
                <li>
                    <a href="/about" class="hover:text-yellow-400 transition">Tentang</a>
                </li>
                <li>
                    <a href="/about#service" class="hover:text-yellow-400 transition">Layanan</a>
                </li>
                <li>
                    <a href="/project" class="hover:text-yellow-400 transition">Proyek</a>
                </li>
                <li>
                    <a href="/article" class="hover:text-yellow-400 transition">Artikel</a>
                </li>
                <li>
                    <a href="/booking" class="hover:text-yellow-400 transition">Pesan</a>
                </li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4 font-poppins">
                Hubungi Kami
            </h4>
            <ul class="space-y-2 text-sm">
                @if($siteSetting?->address)
                    <li>{{ $siteSetting->address }}</li>
                @endif
                @if($siteSetting?->phone)
                    <li><a href="tel:{{ $siteSetting->phone }}" class="hover:text-yellow-400 transition">{{ $siteSetting->phone }}</a></li>
                @endif
                @if($siteSetting?->email)
                    <li><a href="mailto:{{ $siteSetting->email }}" class="hover:text-yellow-400 transition">{{ $siteSetting->email }}</a></li>
                @endif
                <li>Senin – Jumat, 09.00 – 18.00 WIB</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-700 mt-10 pt-6 text-center">
        <div class="max-w-6xl mx-auto text-sm text-gray-400">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ $siteSetting?->site_name ?? 'Cakrawala Event Organizer' }}.
                All Rights Reserved. <br>
                Designed &amp; Developed by
                <span class="font-medium text-gray-700">
                    Kelompok 20 Kerja Praktik Fakultas Ilmu Komputer Universitas Kuningan
                </span>
            </p>
        </div>
    </div>
</footer>
