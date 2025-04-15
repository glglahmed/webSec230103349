<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddCreateEmployeePermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'create_employee', 'guard_name' => 'web']);

        $role = Role::findByName('Admin', 'web');
        $role->givePermissionTo('create_employee');
    }
}