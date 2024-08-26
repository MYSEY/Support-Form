<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Models\PermissionCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PermissionCategoryRequest;

class PermissionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Permission Category');
    }
    public function index()
    {
        $data = DB::table('permission_categories')
        ->leftJoin('users','permission_categories.created_by','=','users.id')
        ->select(
            'permission_categories.*',
            'users.name as created_by',
        )->get();
        return view('permission_category.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionCategoryRequest $request)
    {
        try{
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            PermissionCategory::create($data);
            DB::commit();
            Toastr::success('Create Permission Category successfully.','success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Category fail', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $data = PermissionCategory::find($id);
            return response()->json([
                'success'=>$data
            ]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Get Permission category fail', $e->getMessage());
            return redirect()->back();
        }
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
        try{
            PermissionCategory::where('id',$request->id)->update([
                'name'  =>$request->name,
                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Permission category updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Permission category updated fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            PermissionCategory::destroy($request->id);
            Toastr::success('Permission category deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Permission category delete fail.','Error');
            return redirect()->back();
        }
    }
}
