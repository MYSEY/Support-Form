<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=SuperAdminSeeder
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'user'=>'Super Admin',
            'name'=>'Super Admin',
            'email'=>'superadmin@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
            
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'user'=>'Admin',
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Camma@123'),
            'status'=> 'Active',
        ]);
        $admin->assignRole('Admin');
    }
}
