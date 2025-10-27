<x-app-layout>
    <x-slot name="header">
        Kategori Laporan
    </x-slot>

    <div x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 300)">

        <template x-if="isLoading">
            <x-skeletons.kategori-index />
        </template>

        <div x-show="!isLoading" x-transition>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 py-4">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg shadow">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-4 p-4 bg-white rounded-lg shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <form action="{{ route('kategori-laporan.index') }}" method="GET" class="w-full sm:w-1/2">
                            <label for="search-input" class="sr-only">Cari kategori...</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search-input" value="{{ $search ?? '' }}"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-sky-800 focus:border-sky-800 sm:text-sm"
                                    placeholder="Cari nama kategori...">
                            </div>
                        </form>
                        <a href="{{ route('kategori-laporan.create') }}"
                            class="mt-3 sm:mt-0 sm:ml-4 flex-shrink-0 inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-800 hover:bg-sky-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tambah Kategori
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @forelse ($kategoris as $kategori)
                            <div class="p-4 flex items-center justify-between space-x-4">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800">{{ $kategori->nm_kategori }}</p>
                                    <p class="text-xs text-gray-500">
                                        Digunakan: <span
                                            class="font-medium text-sky-800">{{ $kategori->laporan_harian_count }}</span>
                                        laporan
                                    </p>
                                </div>

                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="text-gray-500 hover:text-gray-700 p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-sky-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('kategori-laporan.edit', $kategori)">
                                            Edit Kategori
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('kategori-laporan.destroy', $kategori) }}"
                                            id="delete-form-{{ $kategori->id_kat }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('kategori-laporan.destroy', $kategori) }}"
                                                class="delete-button block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
                                                data-form-id="delete-form-{{ $kategori->id_kat }}">
                                                Hapus Kategori
                                            </a>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                Tidak ada kategori yang ditemukan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-button').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const formId = this.dataset.formId;

                        Swal.fire({
                            title: 'Yakin mau hapus kategori?',
                            text: "Kategori yang sudah terpakai oleh laporan tidak dapat dihapus.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
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
    @endpush
</x-app-layout>
