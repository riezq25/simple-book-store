<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $customers = Customer::all();

        foreach ($customers as $i => $customer) {
            $randomProducts = $products->random(rand(1, 10));

            $sale = $customer->sales()
                ->create([
                    'invoice_number'    => rand(1, 99) . '-' .  time() . '-' .  rand(1, 99).  rand(1, 99),
                    'customer_id'       => $customer->customer_id,
                    'total_amount'      => 0,
                ]);

            foreach ($randomProducts as $j => $randProduct) {
                $qty = rand(1, 10);
                $subtotal = $randProduct->sale_price * $qty;
                $detail = $sale->details()
                    ->create([
                        'product_id'    => $randProduct->product_id,
                        'unit_price'    => $randProduct->sale_price,
                        'quantity'      => rand(1, 10),
                    ]);

                $sale->total_amount += $subtotal;
                $sale->save();
            }
        }
    }
}
