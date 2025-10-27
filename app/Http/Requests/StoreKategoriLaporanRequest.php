<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya Admin (1) atau Pimpinan (5) yang bisa
        return in_array($this->user()->role_id, [1, 5]);
    }

    public function rules(): array
    {
        return [
            'nm_kategori' => ['required', 'string', 'max:255', 'unique:kat_lap_harian'],
        ];
    }
}
