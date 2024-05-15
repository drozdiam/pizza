<?php

namespace Database\Seeders;

use App\Models\Images;
use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Products::factory()->count(20)->create();

        foreach ($products as $product) {
            Images::factory()->count(3)->create(['product_id' => $product->id]);
        }
    }
}
