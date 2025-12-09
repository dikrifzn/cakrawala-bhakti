<!-- Modal Login -->
<div id="loginModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs hidden items-center justify-center z-80 p-4">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-xl p-8 relative shadow-xl">

        <!-- Close -->
        <button onclick="closeLoginModal()" 
            class="absolute top-4 right-4 text-gray-500 text-lg hover:text-black cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-center text-2xl font-semibold mb-6">Welcome back.</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-300 rounded-md">
                @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium">Username/Email</label>
                <input 
                    type="text" 
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                          class="w-full mt-1 border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 @error('email') border-red-500 @enderror"
                    placeholder="yourmail@gmail.com"
                >
            </div>

            <div>
                <label class="text-sm font-medium">Password</label>
                <div class="relative">
                    <input 
                        type="password"
                        id="passwordInput"
                        name="password"
                        autocomplete="current-password"
                        placeholder="yourpassword"
                        class="w-full mt-1 border border-black rounded-md px-3 py-2 
                               focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                    >

                    <!-- Toggle Button -->
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                        <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" 
                            class="w-5 h-5 text-gray-600 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 
                                     9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" 
                            class="w-5 h-5 text-gray-600"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7
                                     a10.05 10.05 0 012.232-3.592M6.18 6.18A9.959 9.959 
                                     0 0112 5c4.478 0 8.269 2.943 
                                     9.543 7a10.026 10.026 0 01-4.132 
                                     5.225M1 1l22 22"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="inline-block my-3 px-6 py-3 bg-yellow-400 text-black font-semibold rounded-md font-dmsans hover:bg-yellow-500 transition">
                    Sign In
                </button>
            </form>
                <p class="text-center text-sm mt-3">
                    No account? <a onclick="openRegisterModal()" class="text-yellow-600 font-semibold">Create one</a>
                </p>
                <p class="text-center text-xs mt-3">
                    By clicking "Sign in", you accept Cakrawala Bhakti’s <a href="">Terms of Service</a> and <a href="">Privacy Policy</a>.
                </p>
            </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Open/Close Modal
    window.openLoginModal = () => {
        const m = document.getElementById("loginModal");
        m.classList.remove("hidden");
        m.classList.add("flex");
        closeRegisterModal()
    };
    window.closeLoginModal = () => {
        const m = document.getElementById("loginModal");
        m.classList.add("hidden");
        m.classList.remove("flex");
    };

    // Password Toggle
    const passInput = document.getElementById("passwordInput");
    const toggleBtn  = document.getElementById("togglePassword");
    const eye        = document.getElementById("iconEye");
    const eyeOff     = document.getElementById("iconEyeOff");

    toggleBtn.addEventListener("click", () => {
        const isHidden = passInput.type === "password";

        passInput.type = isHidden ? "text" : "password";

        eye.classList.toggle("hidden", !isHidden);
        eyeOff.classList.toggle("hidden", isHidden);
    });

});
</script>
