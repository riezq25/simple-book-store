<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $min = 10_000;
        $max = 200_000;
        $step = 5_000;

        $purchasePrice = fake()->numberBetween($min / $step, $max / $step) * $step;
        $salePrice = intval(ceil((rand(1, 10) / 100 * $purchasePrice))) + $purchasePrice;

        return [
            'product_code'  => fake()
                ->unique()
                ->bothify('?????-#####'),
            'product_name'  => fake()
                ->sentence(rand(1, 3)),
            'category_id'   => Category::factory(),
            'purchase_price'    => $purchasePrice,
            'sale_price'    => $salePrice,
            'stock_quantity'    => rand(1, 100),
        ];
    }
}
