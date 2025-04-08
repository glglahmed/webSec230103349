<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'purchase_products']);
        Permission::create(['name' => 'add_products']);
        Permission::create(['name' => 'edit_products']);
        Permission::create(['name' => 'delete_products']);
        Permission::create(['name' => 'list_customers']);
        Permission::create(['name' => 'show_users']);
        Permission::create(['name' => 'edit_users']);
        Permission::create(['name' => 'delete_users']);
        Permission::create(['name' => 'admin_users']);

        // Create Roles and Assign Permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all()); // Admin has all permissions

        $customerRole = Role::create(['name' => 'Customer']);
        $customerRole->givePermissionTo('purchase_products');

        $employeeRole = Role::create(['name' => 'Employee']);
        $employeeRole->givePermissionTo(['add_products', 'edit_products', 'delete_products', 'list_customers']);
    }
}