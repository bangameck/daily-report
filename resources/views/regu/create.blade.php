<x-app-layout>
    <x-slot name="header">
        Tambah Regu Baru
    </x-slot>

    <div x-data="reguForm()">

        <template x-if="isLoading">
            <x-skeletons.regu-form />
        </template>

        <div x-show="!isLoading" x-transition>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4 py-4">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg shadow">
                        <p class="font-bold">Oops! Ada kesalahan:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form @submit.prevent="submitForm" action="{{ route('regu.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">

                        <div class="flex flex-col items-center space-y-4">
                            <label for="f_regu" class="cursor-pointer">
                                <img :src="imagePreview" alt="Preview Foto Regu"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                            </label>
                            <input type="file" name="f_regu" id="f_regu" class="hidden"
                                accept="image/png, image/jpeg, image/jpg" @change="handleImageSelect($event)">
                            <label for="f_regu"
                                class="cursor-pointer text-sm font-medium text-sky-800 hover:text-sky-700">
                                Pilih Foto Regu (Opsional)
                            </label>
                            @error('f_regu')
                                <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <h3 class="text-lg font-semibold border-b pb-2 text-sky-900">Detail Regu</h3>

                        <x-forms.floating-input name="nm_regu" label="Nama Regu" :value="old('nm_regu')" required />

                        <x-forms.floating-select name="karu" label="Kepala Regu (Karu) - (Opsional)">
                            <option value="">Pilih Kepala Regu</option>
                            @foreach ($karuUsers as $karu)
                                <option value="{{ $karu->id }}" @selected(old('karu') == $karu->id)>
                                    {{ $karu->nama }} ({{ $karu->username }})
                                </option>
                            @endforeach
                        </x-forms.floating-select>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('regu.index') }}"
                                class="mr-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" :disabled="formLoading"
                                class="inline-flex items-center justify-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-900 disabled:opacity-50 min-w-[120px] h-[34px]">
                                <span x-show="!formLoading">Simpan Regu</span>
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
    </div> @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.1/dist/browser-image-compression.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('reguForm', () => ({
                    isLoading: true,
                    formLoading: false,
                    imagePreview: 'https://ui-avatars.com/api/?name=R&color=FFFFFF&background=04449c&size=128',

                    init() {
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 300);
                    },

                    submitForm(event) {
                        this.formLoading = true;
                        setTimeout(() => {
                            event.target.submit();
                        }, 300);
                    },

                    handleImageSelect(event) {
                        const file = event.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        const options = {
                            maxSizeMB: 0.1, // Target < 100KB
                            maxWidthOrHeight: 800,
                            useWebWorker: true,
                        }

                        imageCompression(file, options)
                            .then(compressedFile => {
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(new File([compressedFile], file.name, {
                                    type: file.type
                                }));
                                event.target.files = dataTransfer.files;
                                console.log('Image compressed', compressedFile.size / 1024, 'KB');
                            })
                            .catch(error => console.log(error.message));
                    }
                }));
            });
        </script>
    @endpush

</x-app-layout>
