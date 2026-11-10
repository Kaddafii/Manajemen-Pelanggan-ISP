<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Menjalankan seeding data tagihan pelanggan ISP.
     */
    public function run(): void
    {
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            return;
        }

        $periods = [
            'Januari 2026',
            'Februari 2026',
            'Maret 2026',
        ];

        foreach ($customers as $index => $customer) {
            // Pelanggan dengan index ganjil memiliki 2 atau 3 tagihan, genap memiliki 1 tagihan
            $customerPeriods = ($index % 2 === 0) 
                ? ['Februari 2026', 'Maret 2026'] 
                : ['Januari 2026', 'Februari 2026', 'Maret 2026'];

            foreach ($customerPeriods as $periodIndex => $period) {
                // Sebagian besar Januari dan Februari sudah Lunas, sebagian Maret Belum Bayar
                $isPaid = ($period !== 'Maret 2026') || ($index % 3 === 0);

                $paymentDate = null;
                if ($isPaid) {
                    if ($period === 'Januari 2026') {
                        $paymentDate = Carbon::create(2026, 1, 10 + ($index % 15), 14, 30);
                    } elseif ($period === 'Februari 2026') {
                        $paymentDate = Carbon::create(2026, 2, 8 + ($index % 18), 11, 15);
                    } else {
                        $paymentDate = Carbon::create(2026, 3, 5 + ($index % 5), 9, 20);
                    }
                }

                Invoice::create([
                    'customer_id' => $customer->id,
                    'billing_period' => $period,
                    'billing_amount' => $customer->package_price,
                    'payment_status' => $isPaid ? 'Lunas' : 'Belum Bayar',
                    'payment_date' => $paymentDate,
                    'created_at' => Carbon::create(2026, $periodIndex + 1, 1, 8, 0),
                    'updated_at' => $isPaid ? $paymentDate : Carbon::create(2026, $periodIndex + 1, 1, 8, 0),
                ]);
            }
        }
    }
}
