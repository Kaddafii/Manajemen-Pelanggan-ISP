<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Mendefinisikan status data dummy default untuk entitas Customer.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $packages = [
            ['name' => 'Home Basic 20 Mbps', 'price' => 200000],
            ['name' => 'Home Fast 50 Mbps', 'price' => 350000],
            ['name' => 'Business Pro 100 Mbps', 'price' => 650000],
            ['name' => 'Enterprise Ultra 200 Mbps', 'price' => 1200000],
        ];

        $selectedPackage = fake()->randomElement($packages);

        return [
            'name' => fake()->name(),
            'phone_number' => '08' . fake()->numerify('##########'),
            'address' => fake()->address(),
            'internet_package' => $selectedPackage['name'],
            'package_price' => $selectedPackage['price'],
            'status' => fake()->randomElement(['Aktif', 'Suspend', 'Putus']),
        ];
    }
}
