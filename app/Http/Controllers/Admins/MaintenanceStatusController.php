<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Models\MaintenanceStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class MaintenanceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Maintenance Status');
    }
    public function index()
    {
        $data = MaintenanceStatus::all();
        return view('maintenance_status.index',compact('data'));
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
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            MaintenanceStatus::create($data);
            DB::commit();
            Toastr::success('Created maintenance status successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created maintenance status fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = MaintenanceStatus::where('id',$request->id)->first();
        return response()->json([
            'success'=>$data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = MaintenanceStatus::where('id',$id)->first();
        return response()->json([
            'success'=>$data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            MaintenanceStatus::where('id',$request->id)->update([
                'name'    => $request->name,
                'color'    => $request->color,
                'updated_by'    => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Updated maintenance status successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Updated maintenance status fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            MaintenanceStatus::destroy($request->id);
            Toastr::success('Maintenance status delete successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Maintenance status delete fail.','Error');
            return redirect()->back();
        }
    }
}
