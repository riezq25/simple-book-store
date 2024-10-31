<?php

namespace Database\Seeders;

use Database\Factories\SupplierFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        SupplierFactory::new()
        ->count(1000)
        ->create();
    }
}
