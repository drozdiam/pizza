<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::factory()->count(20)->create();

        foreach ($products as $product) {
            Image::factory()->count(3)->create(['product_id' => $product->id]);
        }
    }
}
