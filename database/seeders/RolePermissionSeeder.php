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
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view ticket']);
        Permission::create(['name' => 'create ticket']);
        Permission::create(['name' => 'update ticket']);
        Permission::create(['name' => 'delete ticket']);

        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();
        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        $adminRole->givePermissionTo(['create permission', 'view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);
        $adminRole->givePermissionTo(['create ticket', 'view ticket', 'update ticket']);

        // Lets give all permission to staff role.
        $staffRole->givePermissionTo(['view user']);

        // Let's Create User and assign Role to it.
        $superAdminUser = User::firstOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'role_id'=>'1',
            'user'=>'Super Admin',
            'name'=>'Super Admin',
            'email'=>'superadmin@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'role_id'=>'2',
            'user'=>'Admin',
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
        ]);
        $adminUser->assignRole($adminRole);

        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'role_id'=>'2',
            'user'=>'Staff',
            'name'=>'Staff',
            'email'=>'staff@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
        ]);
        $staffUser->assignRole($staffRole);
    }
}
