<x-guest-layout>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">
        <!-- Logo dan Judul -->
        <div class="text-center">
            <img class="mx-auto h-20 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo Aplikasi">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Daily Report App
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-6">
            @csrf

            <!-- Username -->
            <div class="relative">
                <input id="username" type="text" name="username" required autofocus autocomplete="username"
                    class="peer w-full h-12 px-4 text-gray-900 border border-gray-300 rounded-md placeholder-transparent focus:outline-none focus:ring-2 focus:ring-sky-800 focus:border-transparent"
                    placeholder="Username">
                <label for="username"
                    class="absolute left-4 -top-3.5 text-gray-600 text-sm bg-white px-1 transition-all
                                  peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3
                                  peer-focus:-top-3.5 peer-focus:text-sky-800 peer-focus:text-sm">
                    Username
                </label>
            </div>

            <!-- Password -->
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="peer w-full h-12 px-4 text-gray-900 border border-gray-300 rounded-md placeholder-transparent focus:outline-none focus:ring-2 focus:ring-sky-800 focus:border-transparent"
                    placeholder="Password">
                <label for="password"
                    class="absolute left-4 -top-3.5 text-gray-600 text-sm bg-white px-1 transition-all
                                  peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3
                                  peer-focus:-top-3.5 peer-focus:text-sky-800 peer-focus:text-sm">
                    Password
                </label>
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M13.477 14.89A6 6 0 015.11 6.523l8.367 8.367zm1.06-1.06L6.17 5.463a6 6 0 018.367 8.367zM10 17a7 7 0 100-14 7 7 0 000 14z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-sky-800 border-gray-300 rounded focus:ring-sky-700">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="text-sm text-sky-800 hover:text-sky-700 font-medium"
                        href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <!-- Error Messages -->
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />


            <!-- Submit Button -->
            <div>
                <button type="submit" id="submit-button"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-800 hover:bg-sky-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 transition-colors disabled:opacity-50">
                    <span id="button-text">Login</span>
                    <span id="loading-spinner" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fitur intip password
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                eyeIcon.classList.toggle('hidden');
                eyeSlashIcon.classList.toggle('hidden');
            });

            // Animasi loading pada submit
            const loginForm = document.getElementById('login-form');
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            loginForm.addEventListener('submit', function() {
                submitButton.disabled = true;
                buttonText.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');
            });
        });
    </script>
</x-guest-layout>
