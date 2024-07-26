<?php

namespace App\Http\Controllers\Admins;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this-> middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create','store']]);
        $this->middleware('permission:update role', ['only' => ['update','edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = Role::all();
        return view('roles.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::all();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $role = Role::create(['guard_name' => 'web','name' => $request->name]);
            $permissions = Permission::pluck('id','id')->all();
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
        $permission = Permission::all();
        $rolePermission = Permission::leftJoin("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->pluck('id')->toArray();
        return view('roles.edit',compact('role','rolePermission','permission'));
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
    public function destroy(string $id)
    {
        //
    }
}
