<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('customer');
        return [
            'user_id'       => $user->id,
            'customer_name' => $user->name,
            'phone_number'  => fake()
                ->numerify('628#########'),
            'email'         => $user->email,
            'address'       => fake()->address(),
            'birth_date'    => fake()->date(),
            'city_code'     => City::inRandomOrder()
                ->first()->city_code,
        ];
    }
}
