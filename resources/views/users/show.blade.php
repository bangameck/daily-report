<x-app-layout>
    <x-slot name="header">
        Detail User
    </x-slot>

    <div x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 300)">

        <template x-if="isLoading">
            <x-skeletons.user-show />
        </template>

        <div x-show="!isLoading" x-transition.opacity.duration.500ms>
            @php
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
                            class="inline-flex items-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-900 active:scale-95 transition-all">
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

                    <div class="grid grid-cols-2 divide-x divide-gray-200 mt-6 pt-4 border-t border-gray-200">
                        <div class="text-center">
                            <span class="text-2xl font-bold text-sky-800">{{ $totalLaporan }}</span>
                            <span class="text-sm text-gray-500 block">Laporan</span>
                        </div>
                        <div class="text-center">
                            <span class="text-base font-bold text-sky-800">{{ $lamaBekerja }}</span>
                            <span class="text-sm text-gray-500 block">Lama Bekerja</span>
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
                        @if ($user->nip)
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
                        @endif
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
                                    <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                    <span class="ml-4 font-medium text-gray-700">Facebook</span>
                                </div>
                                @if ($user->profile->fb)
                                    <a href="https://facebook.com/{{ $user->profile->fb }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm text-sky-700 hover:text-sky-900 font-medium transition-colors">
                                        {{ $user->profile->fb }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-600">-</span>
                                @endif
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.148 3.229-1.669 4.771-4.919 4.919-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.07-1.646-.07-4.85s.012-3.584.07-4.85c.148-3.229 1.669 4.771 4.919 4.919 1.266-.058 1.646.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.059 1.689.073 4.948.073s3.667-.014 4.947-.072c4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.947s-.014-3.667-.072-4.947c-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                    <span class="ml-4 font-medium text-gray-700">Instagram</span>
                                </div>
                                @if ($user->profile->ig)
                                    <a href="https://instagram.com/{{ $user->profile->ig }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm text-sky-700 hover:text-sky-900 font-medium transition-colors">
                                        {{ $user->profile->ig }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-600">-</span>
                                @endif
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                    <span class="ml-4 font-medium text-gray-700">Twitter / X</span>
                                </div>
                                @if ($user->profile->tw)
                                    <a href="https://x.com/{{ $user->profile->tw }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm text-sky-700 hover:text-sky-900 font-medium transition-colors">
                                        {{ $user->profile->tw }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-600">-</span>
                                @endif
                            </div>
                        </div>
                    </nav>
                @endif

                @if ($user->regu_id && $anggotaRegu->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Anggota Regu: {{ $user->regu->nm_regu }}
                        </h3>

                        @php
                            $sortedAnggota = $anggotaRegu->sortBy(function ($anggota) {
                                $role = strtolower($anggota->role->nm_role);
                                switch ($role) {
                                    case 'pengawas':
                                        return 1;
                                    case 'karu':
                                        return 2;
                                    default:
                                        return 3;
                                }
                            });
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-12">

                            @foreach ($sortedAnggota as $anggota)
                                @php
                                    $anggotaAvatar = $anggota->f_ust
                                        ? Storage::url($anggota->f_ust)
                                        : 'https://ui-avatars.com/api/?name=' .
                                            urlencode($anggota->nama) .
                                            '&color=FFFFFF&background=04449c&size=128';

                                    $waNumber = null;
                                    if ($anggota->no_hp) {
                                        $waNumber = preg_replace('/[^0-9]/', '', $anggota->no_hp);
                                        if (substr($waNumber, 0, 1) == '0') {
                                            $waNumber = '62' . substr($waNumber, 1);
                                        }
                                    }

                                    $role = strtolower($anggota->role->nm_role);
                                @endphp

                                <div
                                    class="block bg-white rounded-lg shadow-lg p-4 pt-0 flex flex-col items-center border-t-4 border-sky-800 transform transition-all duration-200 ease-in-out hover:shadow-xl hover:-translate-y-1">

                                    <a href="{{ route('users.show', $anggota) }}" class="flex-shrink-0 -mt-12">
                                        <img src="{{ $anggotaAvatar }}" alt="{{ $anggota->nama }}"
                                            class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
                                    </a>

                                    <a href="{{ route('users.show', $anggota) }}" class="block text-center mt-3">
                                        <p class="text-base font-bold text-sky-900 truncate"
                                            title="{{ $anggota->nama }}">{{ $anggota->nama }}</p>
                                    </a>

                                    @if ($role == 'pengawas')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-800">
                                            {{ $anggota->role->nm_role }}
                                        </span>
                                    @elseif ($role == 'karu')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-semibold text-indigo-800">
                                            {{ $anggota->role->nm_role }}
                                        </span>
                                    @else
                                        <p class="text-xs text-gray-500 text-center">{{ $anggota->role->nm_role }}</p>
                                    @endif

                                    <hr class="my-3 border-t border-gray-100 w-3/4">

                                    <div class="space-y-1 text-xs text-gray-600 text-center">
                                        <p class="truncate px-2"
                                            title="{{ $anggota->alamat ?? 'Alamat tidak diatur' }}">
                                            {{ $anggota->alamat ?? 'Alamat tidak diatur' }}
                                        </p>

                                        @if ($role == 'karu' || $role == 'anggota')
                                            @if ($anggota->profile?->tmt)
                                                @php
                                                    // $anggota->profile->tmt sudah jadi Carbon instance karena cast di model UserProfile
                                                    $tmtDate = $anggota->profile->tmt;
                                                    $now = \Carbon\Carbon::now();
                                                    $diff = $tmtDate->diff($now);
                                                @endphp
                                                <p>
                                                    Lama Bekerja: ({{ $diff->y }} Thn, {{ $diff->m }} Bln,
                                                    {{ $diff->d }} Hr)
                                                </p>
                                            @else
                                                <p>Lama Bekerja: -</p>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-center space-x-3 mt-4 w-full">
                                        @if ($waNumber)
                                            <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center p-2 rounded-full text-green-500 hover:bg-green-100 active:scale-90 transition-all"
                                                title="Chat via WhatsApp">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M.057 23.944l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.93- .52-5.698-1.512L.057 23.944zM7.195 18.067c.273.124.555.188.84.19.063.001.127.001.19.001.233 0 .46-.027.68-.084.795-.208 1.523-.55 2.15-1.001.14-.102.268-.21.38-.324l.08.04c1.46 1.03 3.196 1.597 4.98 1.597 5.365 0 9.73-4.365 9.73-9.73S18.365 2.27 12 2.27s-9.73 4.365-9.73 9.73c0 2.28.784 4.367 2.105 6.03l.05.06c-.11.107-.218.225-.316.336-.46.54-1.08.99-1.79 1.34s-1.46.54-2.22.54c-.06 0-.11-.001-.17-.001a2.81 2.81 0 0 1-.81-.17l-4.22 1.16.8-2.89 1.17-4.21z" />
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($anggota->profile)
                                            @if ($anggota->profile->fb)
                                                <a href="https://facebook.com/{{ $anggota->profile->fb }}"
                                                    target="_blank" rel="noopener noreferrer"
                                                    class="inline-flex items-center justify-center p-2 rounded-full text-blue-600 hover:bg-blue-100 active:scale-90 transition-all"
                                                    title="Facebook">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if ($anggota->profile->ig)
                                                <a href="https://instagram.com/{{ $anggota->profile->ig }}"
                                                    target="_blank" rel="noopener noreferrer"
                                                    class="inline-flex items-center justify-center p-2 rounded-full text-pink-600 hover:bg-pink-100 active:scale-90 transition-all"
                                                    title="Instagram">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.148 3.229-1.669 4.771-4.919 4.919-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.07-1.646-.07-4.85s.012-3.584.07-4.85c.148-3.229 1.669 4.771 4.919 4.919 1.266-.058 1.646.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4-358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.059 1.689.073 4.948.073s3.667-.014 4.947-.072c4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.947s-.014-3.667-.072-4.947c-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if ($anggota->profile->tw)
                                                <a href="https://x.com/{{ $anggota->profile->tw }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center justify-center p-2 rounded-full text-black hover:bg-gray-200 active:scale-90 transition-all"
                                                    title="Twitter / X">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($user->regu_id)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Anggota Regu: {{ $user->regu->nm_regu }}
                        </h3>
                        <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
                            Tidak ada anggota regu lain di regu ini.
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
