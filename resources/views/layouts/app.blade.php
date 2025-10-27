<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>

    <body class="font-sans antialiased">

        @php
            $role = Auth::user()->role_id;
        @endphp

        <header class="sticky top-0 z-40 bg-white shadow-sm h-16 flex items-center justify-between px-4">
            @if (!request()->routeIs('dashboard'))
                <a href="javascript:history.back()" class="text-sky-900 p-2 -ml-2 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @else
                <div class="w-10"></div>
            @endif

            <h1 class="text-lg font-bold text-sky-900 absolute left-1/2 -translate-x-1/2 whitespace-nowrap">
                {{ $header ?? config('app.name', 'Laravel') }}
            </h1>

            <div class="w-10"></div>
        </header>

        <main class="bg-gray-100 min-h-screen pb-20">
            {{ $slot }}
        </main>

        <nav
            class="fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.05)] flex justify-around items-center z-50">

            @if (in_array($role, [1, 5]))
                <a href="{{ route('dashboard') }}"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors {{ request()->routeIs('dashboard') ? 'text-sky-800' : '' }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0L1.72 11.47a.75.75 0 001.06 1.06l8.69-8.69z" />
                        <path
                            d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75v4.5a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                    </svg>
                    <span class="text-xs mt-1 {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Home</span>
                </a>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span class="text-xs mt-1">DataMaster</span>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute bottom-16 mb-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                        <a href="{{ route('users.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Users</a>
                        <a href="{{ route('regu.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Regu</a>
                        <a href="{{ route('kategori-laporan.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kategori
                            Laporan</a>
                    </div>
                </div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A1.875 1.875 0 0118 22.5h-12a1.875 1.875 0 01-1.499-2.382z" />
                        </svg>
                        <span class="text-xs mt-1">Lp. Anggota</span>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute bottom-16 mb-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Seluruh
                            Laporan</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Belum
                            Approve</a>
                    </div>
                </div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span class="text-xs mt-1">Laporan</span>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute bottom-16 mb-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan per
                            Bulan</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan per
                            Pengawas</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Approve
                            Laporan</a>
                    </div>
                </div>
                <a href="{{ route('settings') }}"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors {{ request()->routeIs('settings') ? 'text-sky-800' : '' }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span
                        class="text-xs mt-1 {{ request()->routeIs('settings') ? 'font-semibold' : '' }}">Settings</span>
                </a>
            @elseif(in_array($role, [2, 3]))
                <a href="{{ route('dashboard') }}"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors {{ request()->routeIs('dashboard') ? 'text-sky-800' : '' }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0L1.72 11.47a.75.75 0 001.06 1.06l8.69-8.69z" />
                        <path
                            d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75v4.5a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                    </svg>
                    <span
                        class="text-xs mt-1 {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Home</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span class="text-xs mt-1">Laporan</span>
                </a>
                <a href="{{ route('laporan.create') }}"
                    class="flex items-center justify-center h-16 w-16 bg-gradient-to-r from-sky-800 to-green-700 text-white rounded-full shadow-lg transform -translate-y-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700 hover:scale-105 transition-transform">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs mt-1">History</span>
                </a>
                <a href="{{ route('settings') }}"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors {{ request()->routeIs('settings') ? 'text-sky-800' : '' }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span
                        class="text-xs mt-1 {{ request()->routeIs('settings') ? 'font-semibold' : '' }}">Settings</span>
                </a>
            @elseif($role == 4)
                <a href="{{ route('dashboard') }}"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors {{ request()->routeIs('dashboard') ? 'text-sky-800' : '' }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0L1.72 11.47a.75.75 0 001.06 1.06l8.69-8.69z" />
                        <path
                            d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75v4.5a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                    </svg>
                    <span
                        class="text-xs mt-1 {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Home</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 00-3.741-.538m-4.018 0a9.094 9.094 0 00-3.741.538m7.759 0a7.498 7.498 0 00-3.755-.98S9.75 16.5 9 16.5c-.75 0-1.5.22-2.25.68m11.25 0c.75-.46 1.5-.68 2.25-.68.75 0 1.5.22 2.25.68m-11.25 0a7.498 7.498 0 01-3.755-.98M9.75 6.385a4.125 4.125 0 017.5 0M10.5 6a4.125 4.125 0 00-7.5 0M3 16.5c0 1.32.901 2.41 2.06 2.659M21 16.5c0 1.32-.901 2.41-2.06 2.659" />
                    </svg>
                    <span class="text-xs mt-1 text-center">Lp. Regu</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                    <span class="text-xs mt-1">Approve</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <span class="text-xs mt-1">Lp. Saya</span>
                </a>
                <a href="{{ route('settings') }}"
                    class="flex flex-col items-center justify-center text-gray-500 hover:text-sky-800 transition-colors {{ request()->routeIs('settings') ? 'text-sky-800' : '' }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span
                        class="text-xs mt-1 {{ request()->routeIs('settings') ? 'font-semibold' : '' }}">Settings</span>
                </a>
            @endif

        </nav>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.logout-button').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const formId = this.dataset.formId;
                        Swal.fire({
                            title: 'Yakin mau keluar?',
                            text: "Anda akan logout dari sesi ini.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#0c4a6e',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Logout!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById(formId).submit();
                            }
                        })
                    });
                });
            });
        </script>
        @stack('scripts')
    </body>

</html>
