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
        $permissions = [
            'purchase_products',
            'add_products',
            'edit_products',
            'delete_products',
            'list_customers',
            'show_users',
            'edit_users',
            'delete_users',
            'admin_users',
            'add_credit_to_customers',
            'make_payments',
            'create_employee',
            'store_employee',
            'reset_credit',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Roles and Assign Permissions
        $superUserRole = Role::create(['name' => 'SuperUser', 'guard_name' => 'web']);
        $superUserRole->givePermissionTo(Permission::all()); // SuperUser has all permissions

        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'show_users',
            'edit_users',
            'delete_users',
            'admin_users',
            'add_credit_to_customers',
            'make_payments',
            'create_employee',
            'store_employee',
        ]);

        $employeeRole = Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        $employeeRole->givePermissionTo([
            'add_products',
            'edit_products',
            'delete_products',
            'list_customers',
            'reset_credit',
        ]);

        $customerRole = Role::create(['name' => 'Customer', 'guard_name' => 'web']);
        $customerRole->givePermissionTo('purchase_products');
    }
}