<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alasan'       => ['required', 'string', 'min:20', 'max:1000'],
            'id_postingan' => ['required', 'exists:postingan,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'alasan.required'       => 'Alasan laporan wajib diisi.',
            'alasan.min'            => 'Alasan laporan minimal 20 karakter.',
            'id_postingan.required' => 'Postingan yang dilaporkan tidak valid.',
            'id_postingan.exists'   => 'Postingan tidak ditemukan.',
        ];
    }
}
