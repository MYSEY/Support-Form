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
        // Create Ticket
        $dashboad = PermissionCategory::create(['name'=>'Dashboad']);
        Permission::create(['name' => 'Dashboad View','permission_category_id'=>$dashboad->id]);
        Permission::create(['name' => 'Dashboad New Ticket','permission_category_id'=>$dashboad->id]);
        Permission::create(['name' => 'Dashboad Ticket Critical','permission_category_id'=>$dashboad->id]);
        Permission::create(['name' => 'Dashboad Ticket Assign','permission_category_id'=>$dashboad->id]);
        Permission::create(['name' => 'Dashboad Ticke Active','permission_category_id'=>$dashboad->id]);
        Permission::create(['name' => 'Dashboad User Online','permission_category_id'=>$dashboad->id]);

        // Create Ticket
        $ticket = PermissionCategory::create(['name'=>'Ticket']);
        Permission::create(['name' => 'Ticket View','permission_category_id'=>$ticket->id]);
        Permission::create(['name' => 'Ticket Create','permission_category_id'=>$ticket->id]);
        Permission::create(['name' => 'Ticket Edit','permission_category_id'=>$ticket->id]);
        Permission::create(['name' => 'Ticket Delete','permission_category_id'=>$ticket->id]);
        
        // Create User
        $user = PermissionCategory::create(['name'=>'User']);
        Permission::create(['name' => 'User View','permission_category_id'=>$user->id]);
        Permission::create(['name' => 'User Create','permission_category_id'=>$user->id]);
        Permission::create(['name' => 'User Edit','permission_category_id'=>$user->id]);
        Permission::create(['name' => 'User Delete','permission_category_id'=>$user->id]);

        // Create Ticket Report
        $ticketReport = PermissionCategory::create(['name'=>'Ticket Report']);
        Permission::create(['name' => 'Ticket Report View','permission_category_id'=>$ticketReport->id]);
        
        // Create Role
        $Role = PermissionCategory::create(['name'=>'Role']);
        Permission::create(['name' => 'Role View','permission_category_id'=>$Role->id]);
        Permission::create(['name' => 'Role Create','permission_category_id'=>$Role->id]);
        Permission::create(['name' => 'Role Edit','permission_category_id'=>$Role->id]);
        Permission::create(['name' => 'Role Delete','permission_category_id'=>$Role->id]);

        // Create Permissions
        $Permission = PermissionCategory::create(['name'=>'Permission']);
        Permission::create(['name' => 'Permission View','permission_category_id'=>$Permission->id]);
        Permission::create(['name' => 'Permission Create','permission_category_id'=>$Permission->id]);
        Permission::create(['name' => 'Permission Edit','permission_category_id'=>$Permission->id]);
        Permission::create(['name' => 'Permission Delete','permission_category_id'=>$Permission->id]);

        // Create Permissions Category
        $permissionCategory = PermissionCategory::create(['name'=>'Permission Category']);
        Permission::create(['name' => 'Permission Category View','permission_category_id'=>$permissionCategory->id]);
        Permission::create(['name' => 'Permission Category Create','permission_category_id'=>$permissionCategory->id]);
        Permission::create(['name' => 'Permission Category Edit','permission_category_id'=>$permissionCategory->id]);
        Permission::create(['name' => 'Permission Category Delete','permission_category_id'=>$permissionCategory->id]);

        // Create General
        $general = PermissionCategory::create(['name'=>'General']);
        Permission::create(['name' => 'General View','permission_category_id'=>$general->id]);
        Permission::create(['name' => 'General Create','permission_category_id'=>$general->id]);
        Permission::create(['name' => 'General Edit','permission_category_id'=>$general->id]);
        Permission::create(['name' => 'General Delete','permission_category_id'=>$general->id]);

        // Create help desk
        $helpDesk = PermissionCategory::create(['name'=>'Help Desk']);
        Permission::create(['name' => 'Help Desk View','permission_category_id'=>$helpDesk->id]);
        Permission::create(['name' => 'Help Desk Create','permission_category_id'=>$helpDesk->id]);
        Permission::create(['name' => 'Help Desk Edit','permission_category_id'=>$helpDesk->id]);
        Permission::create(['name' => 'Help Desk Delete','permission_category_id'=>$helpDesk->id]);

        // Create Knowledgebase
        $Knowledgebase = PermissionCategory::create(['name'=>'Knowledgebase']);
        Permission::create(['name' => 'Knowledgebase View','permission_category_id'=>$Knowledgebase->id]);
        Permission::create(['name' => 'Knowledgebase Create','permission_category_id'=>$Knowledgebase->id]);
        Permission::create(['name' => 'Knowledgebase Edit','permission_category_id'=>$Knowledgebase->id]);
        Permission::create(['name' => 'Knowledgebase Delete','permission_category_id'=>$Knowledgebase->id]);

        // Create Status
        $Status = PermissionCategory::create(['name'=>'Status']);
        Permission::create(['name' => 'Status View','permission_category_id'=>$Status->id]);
        Permission::create(['name' => 'Status Create','permission_category_id'=>$Status->id]);
        Permission::create(['name' => 'Status Edit','permission_category_id'=>$Status->id]);
        Permission::create(['name' => 'Status Delete','permission_category_id'=>$Status->id]);

        // Create Department
        $Department = PermissionCategory::create(['name'=>'Department']);
        Permission::create(['name' => 'Department View','permission_category_id'=>$Department->id]);
        Permission::create(['name' => 'Department Create','permission_category_id'=>$Department->id]);
        Permission::create(['name' => 'Department Edit','permission_category_id'=>$Department->id]);
        Permission::create(['name' => 'Department Delete','permission_category_id'=>$Department->id]);

        // Create Branch
        $Branch = PermissionCategory::create(['name'=>'Branch']);
        Permission::create(['name' => 'Branch View','permission_category_id'=>$Branch->id]);
        Permission::create(['name' => 'Branch Create','permission_category_id'=>$Branch->id]);
        Permission::create(['name' => 'Branch Edit','permission_category_id'=>$Branch->id]);
        Permission::create(['name' => 'Branch Delete','permission_category_id'=>$Branch->id]);

        // Create Priority
        $Priority = PermissionCategory::create(['name'=>'Priority']);
        Permission::create(['name' => 'Priority View','permission_category_id'=>$Priority->id]);
        Permission::create(['name' => 'Priority Create','permission_category_id'=>$Priority->id]);
        Permission::create(['name' => 'Priority Edit','permission_category_id'=>$Priority->id]);
        Permission::create(['name' => 'Priority Delete','permission_category_id'=>$Priority->id]);

        // Create Issue Type
        $IssueType = PermissionCategory::create(['name'=>'Issue Type']);
        Permission::create(['name' => 'Issue Type View','permission_category_id'=>$IssueType->id]);
        Permission::create(['name' => 'Issue Type Create','permission_category_id'=>$IssueType->id]);
        Permission::create(['name' => 'Issue Type Edit','permission_category_id'=>$IssueType->id]);
        Permission::create(['name' => 'Issue Type Delete','permission_category_id'=>$IssueType->id]);

        // Create Roles
        $AdminRole = Role::create(['name' => 'Administrator']); //as admin
        $StaffRole = Role::create(['name' => 'Staff']); //as Staff
        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();
        $AdminRole->givePermissionTo($allPermissionNames);
        $userAdmin = User::where("email","admin@gmail.com" )->first();
        $userAdmin->assignRole($AdminRole);
        // Let's Create User and assign Role to it.
        // $userAdmin = User::firstOrCreate([
        //     'email' => 'admin@gmail.com',
        // ], [
        //     'role_id'=>'1',
        //     'user'=>'Administrator',
        //     'name'=>'Administrator',
        //     'email'=>'admin@gmail.com',
        //     'password'=>Hash::make('Camma@123'),
        //     'status'=> 'Active',
        // ]);
        // $userAdmin->assignRole($AdminRole);
    }
}
