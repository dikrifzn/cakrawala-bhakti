@extends('layouts.app')

@section('content')
<section class="py-20 flex flex-col justify-center items-center px-5" data-aos="fade-up" data-aos-delay="100">
    <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-10">
        <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data">
            @csrf

            <h1 class="text-3xl font-bold text-center mb-10">
                Form Pemesanan Acara
            </h1>

            {{-- DATA DIRI --}}
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-5">Data Diri</h2>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block mb-1 font-medium">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="customer_name"
                            class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                            required
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-1 font-medium">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                name="customer_email"
                                class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                                required
                            />
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="customer_phone"
                                class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATA EVENT --}}
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-5">Data Kebutuhan Acara</h2>

                <div class="mb-5">
                    <label class="block mb-1 font-medium">
                        Proposal Acara <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="file"
                        name="proposal"
                        class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400 cursor-pointer"
                        required
                        
                    />
                    <p class="text-sm text-gray-600 mt-1">
                        File proposal berisi deskripsi acara, estimasi budget, dan kebutuhan event
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block mb-1 font-medium">
                            Nama Acara <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="event_name"
                            class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                            required
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-1 font-medium">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                name="start_date"
                                class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                                required
                            />
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                name="end_date"
                                class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                                required
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">
                            Lokasi Acara <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="location"
                            class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                            required
                        />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">
                            Catatan Tambahan
                        </label>
                        <textarea
                            name="notes"
                            class="border rounded-lg p-3 w-full h-32 focus:ring-2 focus:ring-yellow-400"
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button
                    type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 transition text-white py-3 px-8 rounded-xl font-semibold shadow cursor-pointer"
                >
                    Pesan Sekarang
                </button>
            </div>

            <p class="text-sm text-gray-500 mt-4">
                <span class="text-red-500">*</span> Wajib diisi
            </p>
        </form>
    </div>
</section>
@endsection
