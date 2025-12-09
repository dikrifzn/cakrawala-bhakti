@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 pt-24">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pengaturan Profil</h1>
            <p class="mt-2 text-gray-600">Kelola informasi akun Anda di sini</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Sidebar --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="border-t pt-4">
                        <nav class="space-y-2">
                            <a href="{{ route('profile.edit') }}" class="w-full px-4 py-2 rounded-md text-sm font-medium bg-yellow-50 text-yellow-700 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Edit Profil
                            </a>
                            <a href="{{ route('profile.bookings') }}" class="w-full px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Pesanan Saya
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            {{-- Edit Profile Form --}}
            <div class="md:col-span-3">
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Akun</h2>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Name Field --}}
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email Field --}}
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent @error('email') border-red-500 @enderror"
                                placeholder="Masukkan email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Divider --}}
                        <div class="border-t py-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
                            <p class="text-sm text-gray-600 mb-4">Biarkan kosong jika tidak ingin mengubah password</p>

                            {{-- New Password Field --}}
                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent @error('password') border-red-500 @enderror"
                                    placeholder="Masukkan password baru">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password Field --}}
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <input type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent @error('password_confirmation') border-red-500 @enderror"
                                    placeholder="Konfirmasi password baru">
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-4 pt-6">
                            <button type="submit" class="px-6 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ url('/') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
