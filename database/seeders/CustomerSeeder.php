<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Menjalankan seeding data awal pelanggan dengan variasi lengkap untuk keperluan review dan pagination.
     */
    public function run(): void
    {
        $customersList = [
            [
                'name' => 'Budi Santoso',
                'phone_number' => '081234567801',
                'address' => 'Jl. Kenanga No. 12, Jakarta Barat',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Siti Rahmawati',
                'phone_number' => '081234567802',
                'address' => 'Jl. Melati No. 45, Jakarta Selatan',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'phone_number' => '081234567803',
                'address' => 'Jl. Mawar Indah Blok B3, Tangerang',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Dian Permana',
                'phone_number' => '081234567804',
                'address' => 'Komplek Permata Hijau Kav. 8, Bekasi',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Putus',
            ],
            [
                'name' => 'CV Cahaya Abadi',
                'phone_number' => '081234567805',
                'address' => 'Ruko Grand Wisata Blok AA No. 5, Bekasi',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Eko Prasetyo',
                'phone_number' => '081234567806',
                'address' => 'Jl. Anggrek No. 15, Jakarta Pusat',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Fitri Handayani',
                'phone_number' => '081234567807',
                'address' => 'Jl. Cempaka Putih Timur No. 88, Jakarta Pusat',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Gunawan Wibowo',
                'phone_number' => '081234567808',
                'address' => 'Jl. Tebet Barat Dalam VII No. 2, Jakarta Selatan',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Hendra Setiawan',
                'phone_number' => '081234567809',
                'address' => 'Jl. Surya Kencana No. 104, Bogor',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Indah Puspitasari',
                'phone_number' => '081234567810',
                'address' => 'Jl. Margonda Raya No. 450, Depok',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Joko Widodo Susanto',
                'phone_number' => '081234567811',
                'address' => 'Jl. Danau Sunter Utara Blok F No. 12, Jakarta Utara',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Kartika Sari',
                'phone_number' => '081234567812',
                'address' => 'Jl. Kelapa Gading Boulevard Blok LB-1, Jakarta Utara',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Lukman Hakim',
                'phone_number' => '081234567813',
                'address' => 'Jl. Raya Sawangan No. 23, Depok',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Putus',
            ],
            [
                'name' => 'Mega Utami',
                'phone_number' => '081234567814',
                'address' => 'Jl. Bintaro Utama Sektor 3A, Tangerang Selatan',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Nugroho Adiputra',
                'phone_number' => '081234567815',
                'address' => 'Jl. BSD Grand Boulevard Blok C No. 9, Tangerang',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Olivia Tanuwidjaja',
                'phone_number' => '081234567816',
                'address' => 'Apartemen Mediterania Garden Tower B, Jakarta Barat',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'PT Sinergi Data Nusantara',
                'phone_number' => '081234567817',
                'address' => 'Gedung Cyber 2 Lantai 15, Jl. HR Rasuna Said, Jakarta',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Qori Anugerah',
                'phone_number' => '081234567818',
                'address' => 'Jl. Cipete Raya No. 34, Jakarta Selatan',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Rian Hidayat',
                'phone_number' => '081234567819',
                'address' => 'Jl. Karang Tengah Raya No. 7, Tangerang',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Suryadi Pratama',
                'phone_number' => '081234567820',
                'address' => 'Jl. KH Noer Ali Kalimalang No. 18, Bekasi',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Putus',
            ],
            [
                'name' => 'Tri Wahyuni',
                'phone_number' => '081234567821',
                'address' => 'Jl. Ciledug Raya No. 99, Tangerang',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Umar Syarif',
                'phone_number' => '081234567822',
                'address' => 'Jl. Pajajaran No. 50, Bogor',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Vina Panduwinata Putri',
                'phone_number' => '081234567823',
                'address' => 'Jl. Kemang Raya No. 21, Jakarta Selatan',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Wahyu Hidayatullah',
                'phone_number' => '081234567824',
                'address' => 'Jl. Daan Mogot KM 11 No. 4, Jakarta Barat',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Yayasan Bina Prestasi',
                'phone_number' => '081234567825',
                'address' => 'Jl. Pemuda No. 77, Rawamangun, Jakarta Timur',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
        ];

        foreach ($customersList as $customer) {
            Customer::firstOrCreate(
                ['phone_number' => $customer['phone_number']],
                $customer
            );
        }
    }
}
