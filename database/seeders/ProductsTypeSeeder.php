<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Пицца',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Напитки',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        ProductType::insert($roles);
    }
}
