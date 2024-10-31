<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'supplier_name' => fake()->name(),
            'contact_name'  => fake()->name(),
            'phone_number'  => fake()->numerify('081########'),
            'email'         => fake()
                ->unique()
                ->email(),
            'address'       => fake()->address(),
            'city_code'     => City::inRandomOrder()
                ->first()->city_code,
        ];
    }
}
