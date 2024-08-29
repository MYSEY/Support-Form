<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Models\PermissionCategory;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Role');
    }

    public function index()
    {
        // $data = Role::all();
        $data = DB::table('roles')
        ->leftJoin('users', 'roles.id', '=', 'users.role_id')
        ->select(
            'roles.id',
            'roles.name',   
            'roles.role_type', 
            'roles.guard_name', 
            'roles.updated_at', 
            'roles.created_at',
            DB::raw('COUNT(users.id) as user_count')
        )
        ->groupBy(
            'roles.id',
            'roles.name',   
            'roles.role_type', 
            'roles.guard_name', 
            'roles.updated_at', 
            'roles.created_at'
            )
        ->get();
        // dd($data);
        return view('roles.index',compact('data'));
    }

    public function userList(Request $request){
        $users = DB::table('users')->where("role_id", $request->id)
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->leftJoin('departments','departments.id','=','users.department_id')
        ->select(
            'users.*',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'departments.name_english',
        )
        ->get();
        return view('roles.user_list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissionCategory = PermissionCategory::all();
        return view('roles.create',compact('permissionCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        try{
            $role = Role::create([
                'guard_name' => 'web',
                'name' => $request->name,
                'role_type' => $request->role_type,
            ]);
            $permissions = Permission::whereIn('id', $request->permission)->pluck('id','id')->all();
            $role->syncPermissions($permissions);
            DB::commit();
            Toastr::success('Role created successfully.','Success');
            return redirect()->route('role.index');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Role fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        $permissionCategory = PermissionCategory::all();
        $rolePermission = Permission::leftJoin("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->pluck('id')->toArray();
        return view('roles.edit',compact('role','rolePermission','permissionCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try{
            $data = $request->only('name');
            $role->update($data);
            $permissions = Permission::whereIn('id', $request->permission)->get(['name'])->toArray();
            $role->syncPermissions($permissions);
            DB::commit();
            Toastr::success('Role Updated successfully.','Success');
            return redirect()->route('role.index');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create updated fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            Role::destroy($request->id);
            Toastr::success('Role deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Role delete fail.','Error');
            return redirect()->back();
        }
    }
}
