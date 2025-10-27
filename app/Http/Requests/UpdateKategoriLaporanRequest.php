<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role_id, [1, 5]);
    }

    public function rules(): array
    {
        // Ambil ID dari route parameter 'kategori_laporan'
        $kategoriId = $this->route('kategori_laporan')->id_kat;

        return [
            'nm_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kat_lap_harian')->ignore($kategoriId, 'id_kat'),
            ],
        ];
    }
}
