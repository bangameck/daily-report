<x-app-layout>
    <x-slot name="header">
        Buat Laporan Harian
    </x-slot>

    <div x-data="laporanCreateForm(
        {{ $canCreate ? 'true' : 'false' }},
        '{{ $blockReason }}',
        '{{ $jamMulaiDefault }}'
    )">

        <template x-if="isLoading">
            <x-skeletons.laporan-form />
        </template>

        <div x-show="!isLoading" x-transition.opacity.duration.500ms>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4 py-4">

                <template x-if="!canCreate">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg shadow-md"
                        role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="h-8 w-8 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Akses Ditutup</p>
                                <p class="text-sm" x-text="blockReason"></p>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="canCreate">
                    <form @submit.prevent="submitForm" action="{{ route('laporan.store') }}" method="POST"
                        enctype="multipart/form-data" id="laporan-form">
                        @csrf
                        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <x-forms.floating-input name="tgl_lap_display" label="Tanggal"
                                    value="{{ now()->format('d M Y') }}" readonly />
                                <div class="relative">
                                    <input id="jam_s_picker" type="text" name="jam_s" placeholder=" "
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-800 peer" />
                                    <label for="jam_s_picker"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-sky-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-4">
                                        Jam Mulai <span class="text-red-500">*</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input id="jam_f_picker" type="text" name="jam_f" placeholder=" "
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-800 peer" />
                                    <label for="jam_f_picker"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-sky-800 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-4">
                                        Jam Selesai <span class="text-red-500">*</span>
                                    </label>
                                </div>
                            </div>
                            @error('jam_s')
                                <span class="text-xs text-red-600 -mt-5 block">{{ $message }}</span>
                            @enderror
                            @error('jam_f')
                                <span class="text-xs text-red-600 -mt-5 block">{{ $message }}</span>
                            @enderror


                            <h3 class="text-lg font-semibold border-b pb-2 text-sky-900 pt-4">Detail Laporan</h3>

                            <div>
                                <label for="tom-select-kategori" class="text-sm text-gray-500">Kategori Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <select id="tom-select-kategori" name="id_kat" placeholder="Cari kategori kegiatan..."
                                    class="mt-1">
                                    <option value="">Cari kategori kegiatan...</option>
                                    @foreach ($kategoriList as $kategori)
                                        <option value="{{ $kategori->id_kat }}" @selected(old('id_kat') == $kategori->id_kat)>
                                            {{ $kategori->nm_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kat')
                                    <span class="text-xs text-red-600 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <x-forms.floating-textarea name="ket_lap" label="Keterangan Kegiatan" required>
                                {{ old('ket_lap') }}
                            </x-forms.floating-textarea>

                            <div class="border-t border-2 border-dashed border-gray-200 pt-6 space-y-4">
                                <div>
                                    <label for="dokumentasi" class="text-sm font-medium text-gray-700">Dokumentasi
                                        (Foto/Video) <span class="text-red-500">*</span></label>
                                    <p class="text-xs text-gray-500 mb-2">Anda bisa upload beberapa file sekaligus.
                                        Gambar akan dikompres otomatis.</p>
                                    <input type="file" name="dokumentasi[]" id="dokumentasi" multiple
                                        class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-sky-50 file:text-sky-800
                                                  hover:file:bg-sky-100"
                                        accept="image/jpeg,image/png,video/mp4,video/quicktime,video/x-m4v,video/3gpp"
                                        @change="handleFileSelect($event)">
                                    @error('dokumentasi')
                                        <span class="text-xs text-red-600 block">{{ $message }}</span>
                                    @enderror
                                    @error('dokumentasi.*')
                                        <span class="text-xs text-red-600 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="space-y-3" x-show="files.length > 0">
                                    <template x-for="(file, index) in files" :key="file.id">
                                        <div class="bg-gray-50 p-3 rounded-lg border flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <template x-if="file.type.startsWith('image/')">
                                                    <img :src="file.previewUrl"
                                                        class="w-12 h-12 rounded-md object-cover">
                                                </template>
                                                <template x-if="file.type.startsWith('video/')">
                                                    <div
                                                        class="w-12 h-12 rounded-md bg-gray-800 flex items-center justify-center">
                                                        <svg class="h-6 w-6 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate"
                                                    x-text="file.name"></p>
                                                <div class="text-xs text-gray-500">
                                                    <span x-show="file.status === 'compressing'"
                                                        x-text="`Mengompres: ${file.progress.toFixed(0)}%`"></span>
                                                    <span x-show="file.status === 'done' && file.compressedSize"
                                                        x-text="`Selesai: ${(file.originalSize / 1024 / 1024).toFixed(2)} MB -> ${(file.compressedSize / 1024).toFixed(1)} KB`"
                                                        class="text-green-600 font-medium"></span>
                                                    <span x-show="file.status === 'done' && !file.compressedSize"
                                                        x-text="`File video: ${(file.originalSize / 1024 / 1024).toFixed(2)} MB`"></span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                                    <div class="bg-sky-600 h-1.5 rounded-full"
                                                        :style="`width: ${file.progress}%`"></div>
                                                </div>
                                            </div>
                                            <button type="button" @click="removeFile(index, file.id)"
                                                class="text-gray-400 hover:text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t">
                                <a href="{{ route('dashboard') }}"
                                    class="mr-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                    Batal
                                </a>
                                <button type="submit" :disabled="formLoading"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-900 disabled:opacity-50 min-w-[140px] h-[34px]">
                                    <span x-show="!formLoading">Simpan Laporan</span>
                                    <span x-show="formLoading" class="flex items-center justify-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </template>

            </div>
        </div>
    </div> @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.1/dist/browser-image-compression.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('laporanCreateForm', (canCreate, blockReason, jamMulaiDefault) => ({
                    isLoading: true,
                    formLoading: false,
                    canCreate: canCreate,
                    blockReason: blockReason,
                    jamMulaiDefault: jamMulaiDefault,
                    files: [], // Untuk menyimpan list file preview

                    // Kumpulan file asli untuk di-submit
                    fileInputData: new DataTransfer(),

                    init() {
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 300);

                        if (!this.canCreate) {
                            this.$watch('isLoading', val => {
                                if (!val) {
                                    Swal.fire({
                                        title: 'Akses Ditolak!',
                                        text: this.blockReason,
                                        icon: 'error',
                                        confirmButtonColor: '#0c4a6e',
                                        confirmButtonText: 'Kembali ke Dashboard'
                                    }).then(() => {
                                        window.location.href = '{{ route('dashboard') }}';
                                    });
                                }
                            });
                        }

                        this.$watch('isLoading', val => {
                            if (!val && this.canCreate) {
                                this.$nextTick(() => this.initComponents());
                            }
                        });
                    },

                    initComponents() {
                        // Init TomSelect
                        if (window.TomSelect && document.getElementById('tom-select-kategori')) {
                            new TomSelect("#tom-select-kategori", {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "asc"
                                }
                            });
                        }

                        // Init Flatpickr
                        if (window.flatpickr) {
                            // [FIX] Time Picker Jam Mulai
                            flatpickr("#jam_s_picker", {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i",
                                time_24hr: true,
                                defaultDate: this.jamMulaiDefault,
                                locale: 'id'
                            });

                            // [FIX] Time Picker Jam Selesai
                            flatpickr("#jam_f_picker", {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i",
                                time_24hr: true,
                                defaultDate: this.jamMulaiDefault ? this.jamMulaiDefault.split(':')
                                    .map((t, i) => i === 0 ? (parseInt(t) + 1) % 24 : t).join(':') :
                                    '08:00',
                                locale: 'id'
                            });
                        }
                    },

                    submitForm(event) {
                        this.formLoading = true;

                        // [PENTING] Update input file dengan file yg sudah dikompres/dipilih
                        document.getElementById('dokumentasi').files = this.fileInputData.files;

                        setTimeout(() => {
                            event.target.submit();
                        }, 300);
                    },

                    // [BARU] Fungsi kompresi dan file handling yg canggih
                    async handleFileSelect(event) {
                        const newFiles = Array.from(event.target.files);

                        for (const file of newFiles) {
                            const fileId = Date.now() + file.name;
                            const fileData = {
                                id: fileId,
                                name: file.name,
                                type: file.type,
                                previewUrl: URL.createObjectURL(file),
                                progress: 0,
                                originalSize: file.size,
                                compressedSize: null,
                                status: 'pending'
                            };

                            this.files.push(fileData);
                            const fileIndex = this.files.findIndex(f => f.id === fileId);

                            if (file.type.startsWith('image/')) {
                                // Ini Gambar, Kompres!
                                this.files[fileIndex].status = 'compressing';
                                try {
                                    const options = {
                                        maxSizeMB: 0.1, // Target < 100KB
                                        maxWidthOrHeight: 1024,
                                        useWebWorker: true,
                                        onprogress: (p) => {
                                            this.files[fileIndex].progress = p;
                                        }
                                    }

                                    const compressedFile = await imageCompression(file, options);

                                    // Update preview array
                                    this.files[fileIndex].status = 'done';
                                    this.files[fileIndex].progress = 100;
                                    this.files[fileIndex].compressedSize = compressedFile.size;

                                    // Tambahkan ke FileList untuk di-submit
                                    this.fileInputData.items.add(new File([compressedFile], file.name, {
                                        type: file.type
                                    }));

                                } catch (error) {
                                    console.error(error);
                                    this.files[fileIndex].status = 'error';
                                    // Jika gagal kompres, tambahkan file asli
                                    this.fileInputData.items.add(file);
                                }
                            } else {
                                // Ini Video, jangan dikompres
                                this.files[fileIndex].status = 'done';
                                this.files[fileIndex].progress = 100;
                                this.fileInputData.items.add(file);
                            }
                        }

                        // Bersihkan input asli agar bisa pilih file yg sama lagi
                        event.target.value = null;
                    },

                    removeFile(index, fileId) {
                        // 1. Hapus dari array preview
                        const removedFile = this.files.splice(index, 1)[0];

                        // 2. Hapus file dari DataTransfer (fileInputData)
                        const newInputFiles = new DataTransfer();
                        Array.from(this.fileInputData.files).forEach(file => {
                            if (file.name !== removedFile.name) {
                                newInputFiles.items.add(file);
                            }
                        });
                        this.fileInputData = newInputFiles;
                    }
                }));
            });
        </script>
    @endpush

</x-app-layout>
