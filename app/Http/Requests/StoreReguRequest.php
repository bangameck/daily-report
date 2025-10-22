<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReguRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan hanya admin (role_id 1) yang bisa membuat
        return $this->user()->role_id === 1;
    }

    public function rules(): array
    {
        return [
            'nm_regu' => ['required', 'string', 'max:255', 'unique:regu'],
            'karu'    => ['nullable', 'exists:users,id'],                         // Pastikan user karu-nya ada
            'f_regu'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Maks 2MB (sebelum kompresi)
        ];
    }
}
