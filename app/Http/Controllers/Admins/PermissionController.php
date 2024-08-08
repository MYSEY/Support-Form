<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Models\PermissionCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('permissions')->get();
        return view('permission.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('permission_categories')->get();
        return view('permission.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        try{
            $data_per = PermissionCategory::find($request->permission_category_id);
            $permissionName = $data_per->name;
            foreach ($request->permission as $value){
                $check_duplicate = Permission::where('name', $permissionName.' '.$value)->first();
                if(!empty($check_duplicate)){
                    DB::rollback();
                    Toastr::warning('Duplicate entry permission'.' '.$value,'Error');
                    return redirect()->back();
                }
            }
            foreach ($request->permission as $value){
                Permission::create([
                    'permission_category_id'    => $request->permission_category_id,
                    'name'    => $permissionName.' '.$value,
                    'guard_name'    => 'web'
                ]);
            }
            DB::commit();
            Toastr::success('Create Permission successfully.','success');
            return redirect()->route('permission.index');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Permission fail', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Permission::find($id);
        $permissionCategory = PermissionCategory::all();
        return view('permission.edit',compact('data','permissionCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            Permission::destroy($request->id);
            Toastr::success('Permission deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Permission delete fail.','Error');
            return redirect()->back();
        }
    }
}
