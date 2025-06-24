<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view any products', 'view product', 'create product', 'update product', 'delete product',
            'view any warehouses', 'view warehouse', 'create warehouse', 'update warehouse', 'delete warehouse',
            'view any locations', 'view location', 'create location', 'update location', 'delete location',
            'view any inventories', 'view inventory', 'create inventory', 'update inventory', 'delete inventory',
            'view any inbound orders', 'view inbound order', 'create inbound order', 'update inbound order', 'delete inbound order', 'receive inbound order items',
            'view any outbound orders', 'view outbound order', 'create outbound order', 'update outbound order', 'delete outbound order', 'pick outbound order items', 'ship outbound order',
            'manage users', // For user management
            'manage roles', // For role management
            'manage permissions', // For permission management
            'view audit logs', // For viewing audit logs
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create roles and assign permissions
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo([
            'view any products', 'view product', 'create product', 'update product', 'delete product',
            'view any warehouses', 'view warehouse', 'create warehouse', 'update warehouse', 'delete warehouse',
            'view any locations', 'view location', 'create location', 'update location', 'delete location',
            'view any inventories', 'view inventory', 'create inventory', 'update inventory', 'delete inventory',
            'view any inbound orders', 'view inbound order', 'create inbound order', 'update inbound order', 'delete inbound order', 'receive inbound order items',
            'view any outbound orders', 'view outbound order', 'create outbound order', 'update outbound order', 'delete outbound order', 'pick outbound order items', 'ship outbound order',
            'view audit logs',
        ]);

        $warehouseManagerRole = Role::findOrCreate('warehouse-manager');
        $warehouseManagerRole->givePermissionTo([
            'view any products', 'view product',
            'view any warehouses', 'view warehouse', 'update warehouse',
            'view any locations', 'view location', 'create location', 'update location', 'delete location',
            'view any inventories', 'view inventory', 'update inventory',
            'view any inbound orders', 'view inbound order', 'create inbound order', 'update inbound order', 'receive inbound order items',
            'view any outbound orders', 'view outbound order', 'create outbound order', 'update outbound order', 'pick outbound order items', 'ship outbound order',
        ]);

        $pickerRole = Role::findOrCreate('picker');
        $pickerRole->givePermissionTo([
            'view any outbound orders', 'view outbound order', 'pick outbound order items',
            'view any inventories', 'view inventory',
            'view any locations', 'view location',
            'view any products', 'view product'
        ]);

        $receiverRole = Role::findOrCreate('receiver');
        $receiverRole->givePermissionTo([
            'view any inbound orders', 'view inbound order', 'receive inbound order items',
            'view any products', 'view product',
            'view any locations', 'view location',
        ]);

        // Super Admin role with all permissions
        $superAdminRole = Role::findOrCreate('super-admin');
        // No specific permissions assigned here, as Gate::before in AuthServiceProvider handles it.
        // You could also assign all permissions explicitly here if you prefer not to use Gate::before.
        // $superAdminRole->givePermissionTo(Permission::all());
    }
}
