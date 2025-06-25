<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Models\MaintenanceMission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class MaintenanceMissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Maintenance Mission');
    }
    public function index()
    {
        $data = MaintenanceMission::all();
        return view('mission.index',compact('data'));
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
            MaintenanceMission::create($data);
            Toastr::success('Create maintenance mission successfully.','Success');
            DB::commit();
            return redirect('admin/mission');
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $data = MaintenanceMission::find($id);
            return response()->json(['success'=>$data]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
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
    public function update(Request $request, string $id)
    {
        try {
            MaintenanceMission::where('id',$request->id)->update([
                'name'   => $request->name,
                'date'   => $request->date,
                'description'   => $request->description,
                'updated_by'   => Auth::user()->id,
            ]);
            Toastr::success('Updated maintenance mission  successfully.','Success');
            DB::commit();
            return redirect('admin/mission');
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            MaintenanceMission::destroy($request->id);
            Toastr::success('Deleted maintenance mission successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Deleted maintenance mission fail.','Error');
            return redirect()->back();
        }
    }
}
