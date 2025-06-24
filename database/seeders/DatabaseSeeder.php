<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Uncomment if you want to create dummy users

        // Create a default admin user and assign roles/permissions
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AdminUserSeeder::class);

        // You can add more seeders here for Products, Warehouses, etc.
        // $this->call(ProductSeeder::class);
        // $this->call(WarehouseSeeder::class);
    }
}
