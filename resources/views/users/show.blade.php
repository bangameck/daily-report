<x-app-layout>
    <x-slot name="header">
        Detail User
    </x-slot>

    <div x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 300)">

        <template x-if="isLoading">
            <x-skeletons.user-show />
        </template>

        <div x-show="!isLoading" x-transition>
            @php
                // Logika Avatar (kita pakai $user dari controller, bukan Auth::user())
                $avatarUrl = $user->f_ust
                    ? Storage::url($user->f_ust)
                    : 'https://ui-avatars.com/api/?name=' .
                        urlencode($user->nama) .
                        '&color=FFFFFF&background=04449c&size=128';
            @endphp

            <div class="max-w-xl mx-auto p-4">

                @if (Auth::user()->role_id == 1)
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('users.edit', $user) }}"
                            class="inline-flex items-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd"
                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Edit User Ini
                        </a>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex flex-col items-center">
                        <img class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md -mt-16"
                            src="{{ $avatarUrl }}" alt="Foto Profil {{ $user->nama }}">
                        <h2 class="text-2xl font-bold text-gray-900 mt-4">{{ $user->nama }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->role->nm_role }}</p>

                        <span
                            class="mt-2 rounded-full px-3 py-0.5 text-xs font-semibold {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>

                    <div class="flex justify-around items-center mt-6 pt-4 border-t border-gray-200">
                        <div class="text-center">
                            <span class="text-2xl font-bold text-sky-800">{{ $totalLaporan }}</span>
                            <span class="text-sm text-gray-500 block">Laporan</span>
                        </div>
                        <div class="text-center">
                            <span class="text-base font-bold text-sky-800">{{ $bergabungSejak }}</span>
                            <span class="text-sm text-gray-500 block">Bergabung</span>
                        </div>
                    </div>
                </div>

                <nav class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="divide-y divide-gray-200">

                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">Username</span>
                            </div>
                            <span class="text-sm text-gray-600 font-mono">{{ $user->username }}</span>
                        </div>

                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">Email</span>
                            </div>
                            <span class="text-sm text-gray-600">{{ $user->email }}</span>
                        </div>

                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">No. Handphone</span>
                            </div>
                            <span class="text-sm text-gray-600">{{ $user->no_hp }}</span>
                        </div>

                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">Regu</span>
                            </div>
                            <span class="text-sm text-gray-600">{{ $user->regu->nm_regu ?? '-' }}</span>
                        </div>
                    </div>
                </nav>

                <nav class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">NIK</span>
                            </div>
                            <span class="text-sm text-gray-600 font-mono">{{ $user->nik }}</span>
                        </div>
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">NIP</span>
                            </div>
                            <span class="text-sm text-gray-600 font-mono">{{ $user->nip ?? '-' }}</span>
                        </div>
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">Tempat, Tgl Lahir</span>
                            </div>
                            <span class="text-sm text-gray-600">{{ $user->t_lahir ?? '-' }},
                                {{ $user->tgl_lahir ? $user->tgl_lahir->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">Pendidikan</span>
                            </div>
                            <span class="text-sm text-gray-600">{{ $user->pendidikan ?? '-' }}</span>
                        </div>
                        <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center mb-2 sm:mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="ml-4 font-medium text-gray-700">Alamat</span>
                            </div>
                            <span class="text-sm text-gray-600 sm:text-right">{{ $user->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </nav>

                @if ($user->profile)
                    <nav class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class...></svg>
                                    <span class="ml-4 font-medium text-gray-700">Facebook</span>
                                </div>
                                <span class="text-sm text-gray-600">{{ $user->profile->fb ?? '-' }}</span>
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class...></svg>
                                    <span class="ml-4 font-medium text-gray-700">Instagram</span>
                                </div>
                                <span class="text-sm text-gray-600">{{ $user->profile->ig ?? '-' }}</span>
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class...></svg>
                                    <span class="ml-4 font-medium text-gray-700">Twitter / X</span>
                                </div>
                                <span class="text-sm text-gray-600">{{ $user->profile->tw ?? '-' }}</span>
                            </div>
                        </div>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
