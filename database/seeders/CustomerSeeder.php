<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $customersList = [
            [
                'name' => 'John Doe',
                'phone_number' => '081234567801',
                'address' => '14 Baker Street, West Jakarta',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Jane Smith',
                'phone_number' => '081234567802',
                'address' => '27 Oxford Avenue, South Jakarta',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Robert Taylor',
                'phone_number' => '081234567803',
                'address' => '84 Kensington Road, Tangerang',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Emily Watson',
                'phone_number' => '081234567804',
                'address' => '102 Cambridge Street, Bekasi',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Putus',
            ],
            [
                'name' => 'William Clark',
                'phone_number' => '081234567805',
                'address' => '56 Victoria Boulevard, Central Jakarta',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Olivia Harris',
                'phone_number' => '081234567806',
                'address' => '33 Queen Street, Depok',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'James Wilson',
                'phone_number' => '081234567807',
                'address' => '71 High Street, East Jakarta',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Sophia Martin',
                'phone_number' => '081234567808',
                'address' => '19 Church Lane, Bogor',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Alexander White',
                'phone_number' => '081234567809',
                'address' => '45 Windsor Drive, Tangerang Selatan',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Mia Thompson',
                'phone_number' => '081234567810',
                'address' => '88 King George Avenue, West Jakarta',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Daniel Lee',
                'phone_number' => '081234567811',
                'address' => '12 Park Lane, North Jakarta',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Charlotte Walker',
                'phone_number' => '081234567812',
                'address' => '65 Mill Road, South Jakarta',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Benjamin Hall',
                'phone_number' => '081234567813',
                'address' => '23 Greenford Way, Bekasi',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Putus',
            ],
            [
                'name' => 'Amelia Allen',
                'phone_number' => '081234567814',
                'address' => '90 Abbey Road, Central Jakarta',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Lucas Young',
                'phone_number' => '081234567815',
                'address' => '15 Wellington Court, Depok',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Harper King',
                'phone_number' => '081234567816',
                'address' => '78 Regent Street, Tangerang',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Henry Wright',
                'phone_number' => '081234567817',
                'address' => '42 Gloucester Place, Tangerang Selatan',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Evelyn Scott',
                'phone_number' => '081234567818',
                'address' => '61 Paddington Way, South Jakarta',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ethan Green',
                'phone_number' => '081234567819',
                'address' => '39 Richmond Hill, Bogor',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Abigail Adams',
                'phone_number' => '081234567820',
                'address' => '18 Piccadilly Circus, West Jakarta',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Putus',
            ],
            [
                'name' => 'Mason Baker',
                'phone_number' => '081234567821',
                'address' => '54 Trafalgar Square, North Jakarta',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ella Nelson',
                'phone_number' => '081234567822',
                'address' => '73 Whitehall Road, East Jakarta',
                'internet_package' => 'Business Pro 100 Mbps',
                'package_price' => 650000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Logan Carter',
                'phone_number' => '081234567823',
                'address' => '29 Chelsea Embankment, South Jakarta',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Suspend',
            ],
            [
                'name' => 'Grace Mitchell',
                'phone_number' => '081234567824',
                'address' => '87 Soho Square, Central Jakarta',
                'internet_package' => 'Enterprise Ultra 200 Mbps',
                'package_price' => 1200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Jackson Perez',
                'phone_number' => '081234567825',
                'address' => '11 Mayfair Lane, Tangerang',
                'internet_package' => 'Home Basic 20 Mbps',
                'package_price' => 200000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Chloe Campbell',
                'phone_number' => '081234567826',
                'address' => '95 Covent Garden, Bekasi',
                'internet_package' => 'Home Fast 50 Mbps',
                'package_price' => 350000,
                'status' => 'Aktif',
            ],
        ];

        foreach ($customersList as $customerData) {
            Customer::firstOrCreate(
                ['phone_number' => $customerData['phone_number']],
                $customerData
            );
        }
    }
}
