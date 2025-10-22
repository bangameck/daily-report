<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan hanya admin (role_id 1) yang bisa membuat user baru
        return $this->user()->role_id === 1;
    }

    public function rules(): array
    {
        return [
            'nama'       => ['required', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:255', 'unique:users'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'nik'        => ['required', 'string', 'digits:16', 'unique:users'],
            'nip'        => ['nullable', 'string', 'max:255', 'unique:users'],
            'no_hp'      => ['required', 'string', 'max:20', 'starts_with:62'],
            'role_id'    => ['required', 'exists:roles,role_id'],
            'regu_id'    => ['nullable', 'exists:regu,id_regu'],
            'password'   => ['required', 'confirmed', Password::defaults()],
            'f_ust'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status'     => ['required', 'boolean'],
            // Tambahkan sisa field dari migration jika perlu divalidasi
            'pendidikan' => ['nullable', 'string', 'max:100'],
            'alamat'     => ['nullable', 'string'],
            't_lahir'    => ['nullable', 'string', 'max:100'],
            'tgl_lahir'  => ['nullable', 'date'],
            'jk'         => ['nullable', 'in:L,P'],
            'gol_drh'    => ['nullable', 'string', 'max:3'],
            'tmt'        => ['nullable', 'date'],
            'fb'         => ['nullable', 'string', 'max:255'],
            'ig'         => ['nullable', 'string', 'max:255'],
            'tw'         => ['nullable', 'string', 'max:255'],
        ];
    }
}
