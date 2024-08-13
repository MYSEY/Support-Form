<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\PermissionCategory;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
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
        $Role = PermissionCategory::create(['name'=>'Role']);
        $Permission = PermissionCategory::create(['name'=>'Permission']);
        $permissionCategory = PermissionCategory::create(['name'=>'Permission Category']);
        $user = PermissionCategory::create(['name'=>'User']);
        
        // Create Role
        Permission::create(['name' => 'Role View','permission_category_id'=>$Role->id]);
        Permission::create(['name' => 'Role Create','permission_category_id'=>$Role->id]);
        Permission::create(['name' => 'Role Edit','permission_category_id'=>$Role->id]);
        Permission::create(['name' => 'Role Delete','permission_category_id'=>$Role->id]);
        // Create Permissions
        Permission::create(['name' => 'Permission View','permission_category_id'=>$Permission->id]);
        Permission::create(['name' => 'Permission Create','permission_category_id'=>$Permission->id]);
        Permission::create(['name' => 'Permission Edit','permission_category_id'=>$Permission->id]);
        Permission::create(['name' => 'Permission Delete','permission_category_id'=>$Permission->id]);
        // Create Permissions Category
        Permission::create(['name' => 'Permission Category View','permission_category_id'=>$permissionCategory->id]);
        Permission::create(['name' => 'Permission Category Create','permission_category_id'=>$permissionCategory->id]);
        Permission::create(['name' => 'Permission Category Edit','permission_category_id'=>$permissionCategory->id]);
        Permission::create(['name' => 'Permission Category Delete','permission_category_id'=>$permissionCategory->id]);

        // Create User
        Permission::create(['name' => 'User View','permission_category_id'=>$user->id]);
        Permission::create(['name' => 'User Create','permission_category_id'=>$user->id]);
        Permission::create(['name' => 'User Edit','permission_category_id'=>$user->id]);
        Permission::create(['name' => 'User Delete','permission_category_id'=>$user->id]);

        // Create Roles
        $AdminRole = Role::create(['name' => 'Administrator']); //as admin
        $StaffRole = Role::create(['name' => 'Staff']); //as Staff
        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();
        $AdminRole->givePermissionTo($allPermissionNames);

        // Let's Create User and assign Role to it.
        $userAdmin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'role_id'=>'1',
            'user'=>'Administrator',
            'name'=>'Administrator',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
        ]);
        $userAdmin->assignRole($AdminRole);
    }
}
