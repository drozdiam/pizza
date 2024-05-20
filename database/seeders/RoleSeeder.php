<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Role::insert($roles);
    }
}
