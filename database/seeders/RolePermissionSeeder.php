<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=RolePermissionSeeder
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'Role View','permission_category_id'=>1]);
        Permission::create(['name' => 'Role Create','permission_category_id'=>1]);
        Permission::create(['name' => 'Role Update','permission_category_id'=>1]);
        Permission::create(['name' => 'Role Delete','permission_category_id'=>1]);

        Permission::create(['name' => 'Permission View','permission_category_id'=>1]);
        Permission::create(['name' => 'Permission Create','permission_category_id'=>1]);
        Permission::create(['name' => 'Permission Update','permission_category_id'=>1]);
        Permission::create(['name' => 'Permission Delete','permission_category_id'=>1]);

        Permission::create(['name' => 'User View','permission_category_id'=>1]);
        Permission::create(['name' => 'User Create','permission_category_id'=>1]);
        Permission::create(['name' => 'User Update','permission_category_id'=>1]);
        Permission::create(['name' => 'User Delete','permission_category_id'=>1]);

        Permission::create(['name' => 'Ticket View','permission_category_id'=>1]);
        Permission::create(['name' => 'Ticket Create','permission_category_id'=>1]);
        Permission::create(['name' => 'Ticket Update','permission_category_id'=>1]);
        Permission::create(['name' => 'Ticket Delete','permission_category_id'=>1]);

        // Create Roles
        $superAdminRole = Role::create(['name' => 'Administrator']); //as super-admin
        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();
        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        // $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        // $adminRole->givePermissionTo(['create permission', 'view permission']);
        // $adminRole->givePermissionTo(['create user', 'view user', 'update user']);
        // $adminRole->givePermissionTo(['create ticket', 'view ticket', 'update ticket']);

        // Lets give all permission to staff role.
        // $staffRole->givePermissionTo(['view user']);

        // Let's Create User and assign Role to it.
        $superAdminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'role_id'=>'1',
            'user'=>'Administrator',
            'name'=>'Administrator',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
        ]);
        $superAdminUser->assignRole($superAdminRole);
    }
}
