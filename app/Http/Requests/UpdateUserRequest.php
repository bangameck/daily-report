<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan hanya admin (role_id 1) yang bisa mengedit user
        return $this->user()->role_id === 1;
    }

    public function rules(): array
    {
        // Dapatkan user yang akan di-update dari route model binding
        $userId = $this->route('user')->id;

        return [
            'nama'       => ['required', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:255', Rule::unique('users')->ignore($userId)],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'nik'        => ['required', 'string', 'digits:16', Rule::unique('users')->ignore($userId)],
            'nip'        => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($userId)],
            'no_hp'      => ['required', 'string', 'max:20', 'starts_with:62'],
            'role_id'    => ['required', 'exists:roles,role_id'],
            'regu_id'    => ['nullable', 'exists:regu,id_regu'],
            'password'   => ['nullable', 'confirmed', Password::defaults()], // Password boleh kosong
            'f_ust'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status'     => ['required', 'boolean'],
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
