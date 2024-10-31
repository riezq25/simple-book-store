<?php

namespace Database\Seeders;

use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        CategoryFactory::new()
            ->count(30)
            ->has(
                ProductFactory::new()
                    ->count(rand(10, 30))
            )
            ->create();
    }
}
