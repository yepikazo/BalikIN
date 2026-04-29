<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostinganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah dijaga oleh middleware auth
    }

    public function rules(): array
    {
        return [
            'namaBarang'  => ['required', 'string', 'max:255'],
            'jenis'       => ['required', 'in:barangHilang,barangDitemukan'],
            'kategori'    => ['required', 'string', 'max:100'],
            'lokasi'      => ['required', 'string', 'max:255'],
            'deskripsi'   => ['required', 'string', 'max:2000'],
            'foto'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'namaKontak'  => ['required', 'string', 'max:100'],
            'noKontak'    => ['required', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'namaBarang.required'  => 'Nama barang wajib diisi.',
            'jenis.required'       => 'Jenis postingan wajib dipilih.',
            'jenis.in'             => 'Jenis postingan tidak valid.',
            'kategori.required'    => 'Kategori wajib diisi.',
            'lokasi.required'      => 'Lokasi wajib diisi.',
            'deskripsi.required'   => 'Deskripsi wajib diisi.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
            'namaKontak.required'  => 'Nama kontak wajib diisi.',
            'noKontak.required'    => 'Nomor kontak wajib diisi.',
        ];
    }
}
