<!-- Modal Register -->
<div id="registerModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs hidden items-center justify-center z-80 p-4">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-xl p-8 relative shadow-xl">

        <!-- Close -->
        <button onclick="closeRegisterModal()" 
            class="absolute top-4 right-4 text-gray-500 text-lg hover:text-black cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-center text-2xl font-semibold mb-6">Create Account</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-300 rounded-md">
                @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    class="w-full mt-1 border border-black rounded-md px-3 py-2 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                    placeholder="your full name"
                >
            </div>

            <div>
                <label class="text-sm font-medium">Username</label>
                <input 
                    type="text" 
                    name="username"
                    autocomplete="username"
                    class="w-full mt-1 border border-black rounded-md px-3 py-2 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                    placeholder="choose a username"
                >
            </div>

            <div>
                <label class="text-sm font-medium">Email</label>
                <input 
                    type="email" 
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    class="w-full mt-1 border border-black rounded-md px-3 py-2 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                    placeholder="yourmail@gmail.com"
                >
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm font-medium">Password</label>
                <div class="relative">
                    <input 
                        type="password"
                        id="regPassword"
                        name="password"
                        autocomplete="new-password"
                        placeholder="your password"
                        class="w-full mt-1 border border-black rounded-md px-3 py-2 
                               focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                    >

                    <!-- Toggle -->
                    <button type="button" id="toggleRegPassword"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                        <svg id="regEye" xmlns="http://www.w3.org/2000/svg" 
                            class="w-5 h-5 text-gray-600 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 
                                     9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="regEyeOff" xmlns="http://www.w3.org/2000/svg" 
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

            <!-- Confirm Password -->
            <div>
                <label class="text-sm font-medium">Confirm Password</label>
                <div class="relative">
                    <input 
                        type="password"
                        id="regPasswordConfirm"
                        name="password_confirmation"
                        autocomplete="new-password"
                        placeholder="confirm password"
                        class="w-full mt-1 border border-black rounded-md px-3 py-2 
                               focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                    >

                    <!-- Toggle -->
                    <button type="button" id="toggleRegPasswordConfirm"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                        <svg id="regEye2" xmlns="http://www.w3.org/2000/svg" 
                            class="w-5 h-5 text-gray-600 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 
                                     9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="regEyeOff2" xmlns="http://www.w3.org/2000/svg" 
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
                    class="inline-block my-3 px-6 py-3 bg-yellow-400 text-black font-semibold rounded-md font-dmsans hover:bg-yellow-500 transition cursor-pointer">
                    Create Account
                </button>

                <p class="text-center text-sm mt-3">
                    Already have an account? <a onclick="openLoginModal()" class="text-yellow-600 font-semibold cursor-pointer">Sign in</a>
                </p>

                <p class="text-center text-xs mt-3">
                    By creating an account, you agree to our <a href="">Terms</a> and <a href="">Privacy Policy</a>.
                </p>
            </div>
        </form>
    </div>
</div>

<script>
window.openRegisterModal = () => {
    const m = document.getElementById("registerModal");
    m.classList.remove("hidden");
    m.classList.add("flex");
    closeLoginModal();
};
window.closeRegisterModal = () => {
    const m = document.getElementById("registerModal");
    m.classList.add("hidden");
    m.classList.remove("flex");
};

document.addEventListener('DOMContentLoaded', () => {
    const setupToggle = (inputId, eyeId, eyeOffId, btnId) => {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        const eyeOff = document.getElementById(eyeOffId);
        const btn = document.getElementById(btnId);

        btn.addEventListener("click", () => {
            const hidden = input.type === "password";
            input.type = hidden ? "text" : "password";
            eye.classList.toggle("hidden", !hidden);
            eyeOff.classList.toggle("hidden", hidden);
        });
    };

    setupToggle("regPassword", "regEye", "regEyeOff", "toggleRegPassword");
    setupToggle("regPasswordConfirm", "regEye2", "regEyeOff2", "toggleRegPasswordConfirm");
});
</script>
