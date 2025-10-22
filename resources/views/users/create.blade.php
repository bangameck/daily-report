<x-app-layout>
    <x-slot name="header">
        Tambah User Baru
    </x-slot>

    <div x-data="userCreateForm()">

        <template x-if="isLoading">
            <x-skeletons.user-form />
        </template>

        <div x-show="!isLoading" x-transition.opacity.duration.500ms>
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

                <form @submit.prevent="submitForm" action="{{ route('users.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">

                        <div class="flex flex-col items-center space-y-4">
                            <label for="f_ust" class="cursor-pointer">
                                <img :src="imagePreview" alt="Preview Foto Profil"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                            </label>
                            <input type="file" name="f_ust" id="f_ust" class="hidden"
                                accept="image/png, image/jpeg, image/jpg" @change="handleImageSelect($event)">
                            <label for="f_ust"
                                class="cursor-pointer text-sm font-medium text-sky-800 hover:text-sky-700">
                                Pilih Foto Profil (Opsional)
                            </label>
                            @error('f_ust')
                                <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <h3 class="text-lg font-semibold border-b pb-2 text-sky-900">Informasi Akun</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.floating-input name="nama" label="Nama Lengkap" :value="old('nama')" required />

                            <div>
                                <x-forms.floating-input name="username" label="Username" x-model="username"
                                    @input="formatUsername($event)" @keyup.debounce.500ms="checkUsername" required />
                                <div class="text-xs mt-1"
                                    :class="{
                                        'text-green-600': usernameStatus === 'available',
                                        'text-red-600': usernameStatus === 'taken' || usernameStatus === 'invalid',
                                        'text-gray-500': usernameStatus === 'checking'
                                    }"
                                    x-text="usernameMsg">
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-forms.floating-input type="email" name="email" label="Email"
                                x-model.debounce.500ms="email" @blur="checkEmail" :value="old('email')" required />
                            <div class="text-xs mt-1"
                                :class="{
                                    'text-green-600': emailStatus === 'available',
                                    'text-red-600': emailStatus === 'taken',
                                    'text-gray-500': emailStatus === 'checking'
                                }"
                                x-text="emailMsg">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <x-forms.floating-input x-bind:type="showPass ? 'text' : 'password'" name="password"
                                    label="Password" @input="validatePassword($event)" required />
                                <button type="button" @click="showPass = !showPass"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-gray-500">
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.022 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.022 7 9.542 7 1.136 0 2.22.217 3.231.624m3.454 4.542a3.001 3.001 0 00-4.095-4.095L13.875 18.825zM10.5 10.5L13.5 13.5">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="relative">
                                <x-forms.floating-input x-bind:type="showConfirmPass ? 'text' : 'password'"
                                    name="password_confirmation" label="Konfirmasi Password"
                                    @input="validateConfirmPassword($event)" required />
                                <button type="button" @click="showConfirmPass = !showConfirmPass"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-gray-500">
                                    <svg x-show="!showConfirmPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.022 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg x-show="showConfirmPass" x-cloak class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.022 7 9.542 7 1.136 0 2.22.217 3.231.624m3.454 4.542a3.001 3.001 0 00-4.095-4.095L13.875 18.825zM10.5 10.5L13.5 13.5">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18"></path>
                                    </svg>
                                </button>
                                <div x-show="confirmPassword.length > 0" class="text-xs mt-1"
                                    :class="passMatch ? 'text-green-600' : 'text-red-600'"
                                    x-text="passMatch ? 'Password cocok!' : 'Password tidak cocok.'">
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold border-b pb-2 text-sky-900 pt-4">Informasi Personal</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.floating-input name="nik" label="NIK (16 digit)" :value="old('nik')"
                                @input="formatNumeric($event, 16)" required />
                            <x-forms.floating-input name="nip" label="NIP (18 digit, Opsional)" :value="old('nip')"
                                @input="formatNumeric($event, 18)" />
                        </div>

                        <x-forms.floating-input name="no_hp" label="No. Handphone / WA" :value="old('no_hp', '62')"
                            @input="formatPhone($event)" required />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.floating-input type="text" name="t_lahir" label="Tempat Lahir (Opsional)"
                                :value="old('t_lahir')" />

                            <div class="relative">
                                <input id="tgl_lahir_picker" type="text" name="tgl_lahir"
                                    value="{{ old('tgl_lahir') }}" placeholder=" "
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-800 peer" />
                                <label for="tgl_lahir_picker"
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
                                           peer-focus:px-2 peer-focus:text-sky-800
                                           peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                                           peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                                           start-4">
                                    Tanggal Lahir (Opsional)
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <fieldset class="border border-gray-300 rounded-lg p-4">
                                <legend class="text-sm text-gray-500 px-2">Jenis Kelamin (Opsional)</legend>
                                <div class="flex items-center justify-around">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="jk" value="L" class="sr-only peer"
                                            @checked(old('jk') == 'L')>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-800">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="jk" value="P" class="sr-only peer"
                                            @checked(old('jk') == 'P')>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-pink-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Perempuan</span>
                                    </label>
                                </div>
                            </fieldset>

                            <x-forms.floating-select name="gol_drh" label="Gol. Darah (Opsional)">
                                <option value="">Pilih Gol. Darah</option>
                                <option value="A" @selected(old('gol_drh') == 'A')>A</option>
                                <option value="B" @selected(old('gol_drh') == 'B')>B</option>
                                <option value="AB" @selected(old('gol_drh') == 'AB')>AB</option>
                                <option value="O" @selected(old('gol_drh') == 'O')>O</option>
                            </x-forms.floating-select>
                        </div>

                        <x-forms.floating-input name="pendidikan" label="Pendidikan Terakhir (Opsional)"
                            :value="old('pendidikan')" />

                        <div>
                            <label for="alamat" class="text-sm text-gray-500">Alamat (Opsional)</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-800 focus:ring-sky-800 sm:text-sm">{{ old('alamat') }}</textarea>
                        </div>


                        <h3 class="text-lg font-semibold border-b pb-2 text-sky-900 pt-4">Informasi Tambahan & Sosmed
                        </h3>

                        <div class="relative">
                            <input id="tmt_picker" {{-- ID BARU --}} type="text" name="tmt"
                                value="{{ old('tmt') }}" placeholder=" "
                                class="block w-full px-4 py-3 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-sky-800 peer" />
                            <label for="tmt_picker"
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
                                       peer-focus:px-2 peer-focus:text-sky-800
                                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                                       peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                                       start-4">
                                TMT (Tgl Mulai Bekerja) - Opsional
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.floating-input name="fb" label="Facebook (Opsional)" :value="old('fb')" />
                            <x-forms.floating-input name="ig" label="Instagram (Opsional)" :value="old('ig')" />
                        </div>
                        <x-forms.floating-input name="tw" label="Twitter / X (Opsional)" :value="old('tw')" />


                        <h3 class="text-lg font-semibold border-b pb-2 text-sky-900 pt-4">Hak Akses</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.floating-select name="role_id" label="Role / Level" required>
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->role_id }}" @selected(old('role_id') == $role->role_id)>
                                        {{ $role->nm_role }}</option>
                                @endforeach
                            </x-forms.floating-select>
                            <x-forms.floating-select name="regu_id" label="Regu (Opsional)">
                                <option value="">Pilih Regu</option>
                                @foreach ($regus as $regu)
                                    <option value="{{ $regu->id_regu }}" @selected(old('regu_id') == $regu->id_regu)>
                                        {{ $regu->nm_regu }}</option>
                                @endforeach
                            </x-forms.floating-select>
                        </div>

                        <x-forms.floating-select name="status" label="Status Akun" required>
                            <option value="1" @selected(old('status') == '1')>Aktif</option>
                            <option value="0" @selected(old('status') == '0')>Non-Aktif</option>
                        </x-forms.floating-select>

                        <div class="flex justify-end pt-4">
                            <a href="{{ route('users.index') }}"
                                class="mr-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" :disabled="formLoading"
                                class="inline-flex items-center justify-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-900 disabled:opacity-50 min-w-[120px] h-[34px]">
                                <span x-show="!formLoading">Simpan User</span>
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
        <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('userCreateForm', () => ({
                    isLoading: true,
                    formLoading: false,
                    imagePreview: 'https://ui-avatars.com/api/?name=?&color=FFFFFF&background=04449c&size=128',
                    showPass: false,
                    showConfirmPass: false,
                    username: '{{ old('username', '') }}',
                    usernameStatus: '{{ $errors->has('username') ? 'taken' : 'idle' }}',
                    usernameMsg: '{{ $errors->first('username') }}' || '',
                    email: '{{ old('email', '') }}',
                    emailStatus: '{{ $errors->has('email') ? 'taken' : 'idle' }}',
                    emailMsg: '{{ $errors->first('email') }}' || '',
                    password: '',
                    confirmPassword: '',
                    passMatch: false,

                    init() {
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 300);
                        this.$watch('isLoading', val => {
                            if (!val) {
                                // Tunggu DOM update, baru init SEMUA komponen
                                this.$nextTick(() => this.initComponents());
                            }
                        });
                    },

                    // [MODIFIKASI] Ganti nama fungsi & tambahkan Flatpickr
                    initComponents() {
                        // 1. Inisialisasi Flowbite (untuk Toggle, dll)
                        initFlowbite();

                        // 2. Inisialisasi Flatpickr
                        // Pastikan flatpickr dan Indonesian sudah di-load dari app.js
                        if (window.flatpickr) {
                            if (document.getElementById('tgl_lahir_picker')) {
                                flatpickr("#tgl_lahir_picker", {
                                    dateFormat: 'Y-m-d',
                                    altInput: true,
                                    altFormat: 'd M Y',
                                    disableMobile: false, // Ini akan pakai native wheel di HP
                                    locale: 'id' // Ini akan berfungsi karena kita register di app.js
                                });
                            }

                            // [BARU] Datepicker TMT
                            if (document.getElementById('tmt_picker')) {
                                flatpickr("#tmt_picker", {
                                    dateFormat: 'Y-m-d',
                                    altInput: true,
                                    altFormat: 'd M Y',
                                    disableMobile: false,
                                    locale: 'id'
                                });
                            }
                        }
                    },

                    submitForm(event) {
                        this.formLoading = true;
                        // Cek jika username atau email sedang dicek
                        if (this.usernameStatus === 'checking' || this.emailStatus === 'checking') {
                            alert('Harap tunggu pengecekan username/email selesai.');
                            this.formLoading = false;
                            return;
                        }
                        // Cek jika username atau email sudah terpakai
                        if (this.usernameStatus === 'taken' || this.emailStatus === 'taken') {
                            alert('Username atau Email sudah terdaftar.');
                            this.formLoading = false;
                            return;
                        }
                        // Cek jika password tidak cocok
                        if (this.password.length > 0 && !this.passMatch) {
                            alert('Password dan Konfirmasi Password tidak cocok.');
                            this.formLoading = false;
                            return;
                        }

                        setTimeout(() => {
                            event.target.submit();
                        }, 300);
                    },

                    formatNumeric(event, maxLength) {
                        event.target.value = event.target.value.replace(/[^0-9]/g, '').slice(0, maxLength);
                    },

                    formatUsername(event) {
                        let value = event.target.value;
                        value = value.toLowerCase().replace(/\s/g, '');
                        value = value.replace(/[^a-z0-9_\-]/g, '');
                        event.target.value = value;
                        this.username = value;

                        if (value.length > 0 && !/^[a-z0-9][a-z0-9_\-]*$/.test(value)) {
                            this.usernameStatus = 'invalid';
                            this.usernameMsg =
                                'Hanya boleh huruf kecil, angka, _ dan - (diawali huruf/angka).';
                        } else {
                            this.usernameStatus = 'idle';
                            this.usernameMsg = '{{ $errors->first('username') }}' || '';
                        }
                    },

                    checkUsername: Alpine.debounce(function() {
                        if (this.username.length < 4) {
                            this.usernameStatus = 'invalid';
                            this.usernameMsg = 'Username minimal 4 karakter.';
                            return;
                        }
                        if (!/^[a-z0-9][a-z0-9_\-]*$/.test(this.username)) {
                            this.usernameStatus = 'invalid';
                            this.usernameMsg = 'Format username tidak valid.';
                            return;
                        }

                        this.usernameStatus = 'checking';
                        this.usernameMsg = 'Mengecek ketersediaan...';

                        fetch('{{ route('users.checkUsername') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    username: this.username
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.available) {
                                    this.usernameStatus = 'available';
                                    this.usernameMsg = 'Username tersedia!';
                                } else {
                                    this.usernameStatus = 'taken';
                                    this.usernameMsg = 'Username sudah digunakan.';
                                }
                            });
                    }, 500),

                    checkEmail: Alpine.debounce(function() {
                        if (this.email.length === 0 || !/^\S+@\S+\.\S+$/.test(this.email)) {
                            this.emailStatus = 'idle';
                            this.emailMsg = '{{ $errors->first('email') }}' || '';
                            return;
                        }

                        this.emailStatus = 'checking';
                        this.emailMsg = 'Mengecek email...';

                        fetch('{{ route('users.checkEmail') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    email: this.email
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.available) {
                                    this.emailStatus = 'available';
                                    this.emailMsg = 'Email tersedia!';
                                } else {
                                    this.emailStatus = 'taken';
                                    this.emailMsg = 'Email sudah terdaftar.';
                                }
                            });
                    }, 500),

                    validatePassword(event) {
                        event.target.value = event.target.value.replace(/\s/g, '');
                        this.password = event.target.value;
                        this.validatePasswordMatch();
                    },

                    validateConfirmPassword(event) {
                        event.target.value = event.target.value.replace(/\s/g, '');
                        this.confirmPassword = event.target.value;
                        this.validatePasswordMatch();
                    },

                    validatePasswordMatch() {
                        if (this.password.length > 0 || this.confirmPassword.length > 0) {
                            this.passMatch = this.password === this.confirmPassword;
                        } else {
                            this.passMatch = true; // Jika keduanya kosong, anggap "cocok" (valid)
                        }
                    },

                    formatPhone(event) {
                        let value = event.target.value.replace(/[^0-9]/g, '');
                        if (value.startsWith('0')) {
                            value = '62' + value.substring(1);
                        }
                        if (value.length > 0 && !value.startsWith('62')) {
                            value = '62' + value;
                        }
                        event.target.value = value.slice(0, 20);
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
