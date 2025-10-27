<x-app-layout>
    <x-slot name="header">
        Edit Kategori
    </x-slot>

    <div x-data="{ isLoading: true, formLoading: false }" x-init="setTimeout(() => { isLoading = false }, 300)">

        <template x-if="isLoading">
            <x-skeletons.kategori-form />
        </template>

        <div x-show="!isLoading" x-transition>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4 py-4">

                @if ($errors->any())
                @endif

                <form @submit="formLoading = true" action="{{ route('kategori-laporan.update', $kategori_laporan) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">

                        <h3 class="text-lg font-semibold border-b pb-2 text-sky-900">Detail Kategori</h3>

                        <x-forms.floating-textarea name="nm_kategori" label="Nama Kategori Laporan" required>
                            {{ old('nm_kategori', $kategori_laporan->nm_kategori) }}
                        </x-forms.floating-textarea>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('kategori-laporan.index') }}"
                                class="mr-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" :disabled="formLoading"
                                class="inline-flex items-center justify-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-900 disabled:opacity-50 min-w-[120px] h-[34px]">
                                <span x-show="!formLoading">Update</span>
                                <span x-show="formLoading" class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

