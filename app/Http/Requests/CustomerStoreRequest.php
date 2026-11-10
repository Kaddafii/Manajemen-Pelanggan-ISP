<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    /**
     * Menentukan otorisasi pengguna untuk membuat pelanggan baru.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi eksplisit penambahan data pelanggan baru.
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
            'phone_number' => [
                'required',
                'string',
                'max:20',
            ],
            'address' => [
                'required',
                'string',
            ],
            'internet_package' => [
                'required',
                'string',
                'max:100',
            ],
            'package_price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],
            'status' => [
                'required',
                'string',
                'in:Aktif,Suspend,Putus',
            ],
        ];
    }

    /**
     * Pesan error validasi secara eksplisit.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'name.string' => 'Nama pelanggan harus berupa teks.',
            'name.max' => 'Nama pelanggan maksimal 100 karakter.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.required' => 'Alamat pelanggan wajib diisi.',
            'address.string' => 'Alamat pelanggan harus berupa teks.',
            'internet_package.required' => 'Paket internet wajib dipilih atau diisi.',
            'internet_package.string' => 'Paket internet harus berupa teks.',
            'internet_package.max' => 'Paket internet maksimal 100 karakter.',
            'package_price.required' => 'Harga paket wajib diisi.',
            'package_price.numeric' => 'Harga paket harus berupa angka valid.',
            'package_price.min' => 'Harga paket tidak boleh bernilai negatif.',
            'package_price.max' => 'Harga paket melebihi batas maksimum nominal.',
            'status.required' => 'Status pelanggan wajib dipilih.',
            'status.in' => 'Status pelanggan harus salah satu dari: Aktif, Suspend, atau Putus.',
        ];
    }
}
