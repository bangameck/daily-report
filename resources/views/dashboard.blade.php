<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 500)">

        <template x-if="isLoading">
            <div class="py-4 animate-pulse">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="h-6 w-3/4 bg-gray-300 rounded"></div>
                        <div class="h-4 w-1/2 bg-gray-300 rounded mt-3"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg shadow-sm p-6 h-28"></div>
                        <div class="bg-white rounded-lg shadow-sm p-6 h-28"></div>
                        <div class="bg-white rounded-lg shadow-sm p-6 h-28"></div>
                    </div>
                </div>
            </div>
        </template>

        <div x-show="!isLoading" x-transition>
            <div class="py-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-xl font-medium">Selamat Datang, {{ Auth::user()->nama }}! 👋</h3>
                            <p class="mt-2 text-gray-600">
                                Anda login sebagai: <span
                                    class="font-semibold text-sky-800">{{ Auth::user()->role->nm_role }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6"> ... </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6"> ... </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6"> ... </div>
                    </div>

                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
