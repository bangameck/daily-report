<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReguRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role_id === 1;
    }

    public function rules(): array
    {
        $reguId = $this->route('regu')->id_regu;

        return [
            'nm_regu' => ['required', 'string', 'max:255', Rule::unique('regu')->ignore($reguId, 'id_regu')],
            'karu'    => ['nullable', 'exists:users,id'],
            'f_regu'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
