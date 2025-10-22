<x-app-layout>
    <x-slot name="header">
        {{ __('Settings') }}
    </x-slot>

    <div x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 500)">

        <template x-if="isLoading">
            <x-skeleton-settings />
        </template>

        <div x-show="!isLoading" x-transition>
            @php
                $user = Auth::user();
                $role = $user->role_id;

                // Logika Avatar
                $avatarUrl = $user->f_ust
                    ? asset('storage/' . $user->f_ust)
                    : 'https://ui-avatars.com/api/?name=' .
                        urlencode($user->nama) .
                        '&color=FFFFFF&background=04449c&size=128';
            @endphp

            <div class="max-w-xl mx-auto p-4">
                <div class="bg-gradient-to-br from-sky-800 to-green-700 rounded-2xl shadow-lg p-6 text-white">

                    <div class="flex justify-center">
                        <img class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-md"
                            src="{{ $avatarUrl }}" alt="Foto Profil {{ $user->nama }}">
                    </div>

                    <div class="text-center mt-4">
                        <h2 class="text-2xl font-bold">{{ $user->nama }}</h2>
                        <p class="text-sm text-sky-100">{{ $user->role->nm_role }}</p>

                        <div
                            class="mt-4 flex flex-col sm:flex-row justify-center items-center sm:space-x-4 space-y-2 sm:space-y-0 text-sm font-medium">
                            @if ($user->regu)
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0110 9c-1.55 0-2.958.428-4.07 1.125a6.97 6.97 0 00-1.5 4.33c0 .34.024.673.07 1h10.86zM10 19a1 1 0 001-1 7 7 0 00-14 0 1 1 0 001 1h12zM17 19a1 1 0 001-1 7 7 0 00-14 0 1 1 0 001 1h12z" />
                                    </svg>
                                    {{ $user->regu->nm_regu }}
                                </span>
                            @endif
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                {{ $user->no_hp ?? 'No. HP belum diisi' }}
                            </span>
                        </div>
                    </div>
                </div>

                <nav class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="divide-y divide-gray-200">

                        <a href="#"
                            class="flex items-center justify-between p-4 text-gray-700 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="ml-4 font-medium">Ubah Profil</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>

                        @if (in_array($role, [1, 5]))
                            <a href="#"
                                class="flex items-center justify-between p-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                    <span class="ml-4 font-medium">Backup Database</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" id="logout-form-settings">
                            @csrf
                            <a href="{{ route('logout') }}"
                                class="logout-button flex items-center justify-between p-4 text-red-600 hover:bg-red-50 transition-colors"
                                data-form-id="logout-form-settings">

                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="ml-4 font-medium">Logout</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </form>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</x-app-layout>
