<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceStoreRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna memiliki otorisasi untuk melakukan permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi penyimpanan data tagihan baru secara eksplisit sesuai aturan C.4.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => [
                'required',
                'integer',
                Rule::exists('customers', 'id')->whereNull('deleted_at'),
            ],
            'billing_period' => [
                'required',
                'string',
                'max:50',
            ],
            'billing_amount' => [
                'required',
                'numeric',
                'min:0',
            ],
            'payment_status' => [
                'required',
                'string',
                Rule::in(['Belum Bayar', 'Lunas']),
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
            'customer_id.required' => 'Pelanggan wajib dipilih.',
            'customer_id.integer' => 'ID pelanggan harus berupa bilangan bulat.',
            'customer_id.exists' => 'Pelanggan yang dipilih tidak ditemukan dalam sistem.',
            'billing_period.required' => 'Periode tagihan wajib diisi.',
            'billing_period.string' => 'Periode tagihan harus berupa teks.',
            'billing_period.max' => 'Periode tagihan maksimal berisi 50 karakter.',
            'billing_amount.required' => 'Nominal tagihan wajib diisi.',
            'billing_amount.numeric' => 'Nominal tagihan harus berupa angka numerik valid.',
            'billing_amount.min' => 'Nominal tagihan minimal adalah Rp 0.',
            'payment_status.required' => 'Status pembayaran wajib dipilih.',
            'payment_status.string' => 'Status pembayaran harus berupa teks.',
            'payment_status.in' => 'Status pembayaran hanya boleh bernilai Belum Bayar atau Lunas.',
        ];
    }
}
