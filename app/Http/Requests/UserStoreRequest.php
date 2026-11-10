<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna memiliki otorisasi untuk melakukan permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdministratorRole();
    }

    /**
     * Aturan validasi penyimpanan data pengguna baru secara eksplisit sesuai aturan C.4.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'role' => [
                'required',
                'string',
                Rule::in(['Administrator', 'Staff']),
            ],
        ];
    }

    /**
     * Pesan kesalahan validasi dalam Bahasa Indonesia secara eksplisit.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.string' => 'Nama pengguna harus berupa teks.',
            'name.max' => 'Nama pengguna maksimal 100 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.string' => 'Alamat email harus berupa teks.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email maksimal 100 karakter.',
            'email.unique' => 'Alamat email ini sudah terdaftar dalam sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal berisi 6 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.string' => 'Role pengguna harus berupa teks.',
            'role.in' => 'Role pengguna hanya boleh bernilai Administrator atau Staff.',
        ];
    }
}
