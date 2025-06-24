<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // You should change this in production
                'email_verified_at' => now(),
            ]
        );

        // Assign 'super-admin' role to the admin user
        $superAdminRole = Role::findByName('super-admin');
        if ($superAdminRole && !$user->hasRole('super-admin')) {
            $user->assignRole($superAdminRole);
        }

        // Create a warehouse manager user
        $warehouseManager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Warehouse Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $warehouseManagerRole = Role::findByName('warehouse-manager');
        if ($warehouseManagerRole && !$warehouseManager->hasRole('warehouse-manager')) {
            $warehouseManager->assignRole($warehouseManagerRole);
        }

        // Create a picker user
        $picker = User::firstOrCreate(
            ['email' => 'picker@example.com'],
            [
                'name' => 'Picker User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $pickerRole = Role::findByName('picker');
        if ($pickerRole && !$picker->hasRole('picker')) {
            $picker->assignRole($pickerRole);
        }

        // Create a receiver user
        $receiver = User::firstOrCreate(
            ['email' => 'receiver@example.com'],
            [
                'name' => 'Receiver User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $receiverRole = Role::findByName('receiver');
        if ($receiverRole && !$receiver->hasRole('receiver')) {
            $receiver->assignRole($receiverRole);
        }
    }
}
