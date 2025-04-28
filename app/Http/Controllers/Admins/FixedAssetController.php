<?php

namespace App\Http\Controllers\Admins;

use App\Models\Room;
use App\Models\Asset;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Employee;
use App\Imports\AssetImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Asset');
    }
    public function index(Request $request)
    {
        try {
            // Fetch assets from the default database
            $data = Asset::leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
            ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
            ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id')
            ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
            ->select(
                'assets.*', 
                'assets.serial', 
                'assets.date', 
                'assets.device_name', 
                'categories.name as category_name', 
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'positions.name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'rooms.name as location_name',
            )->get();
            return view('asset.index',compact('data'));
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cateagory = Category::all();
        $location = Room::all();
        $office = Branch::all();
        $users = Employee::whereIn('emp_status',['Probation','1','10','2'])
        ->select(
            'users.id',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
        )->get();
        return view('asset.create',compact('cateagory','location','office','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            Asset::create($data);
            Toastr::success('Asset create successfully.','Success');
            DB::commit();
            return redirect('admin/asset');
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cateagory = Category::all();
        $location = Room::all();
        $office = Branch::all();
        $users = Employee::whereIn('emp_status',['Probation','1','10','2'])
        ->select(
            'users.id',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
        )->get();
        $data = Asset::where('id',$id)->first();
        return view('asset.edit',compact('data','cateagory','location','office','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Asset::where('id',$request->id)->update([
                'category_id'   => $request->category_id,
                'office'   => $request->office,
                'location'   => $request->location,
                'end_user'   => $request->end_user,
                'serial'   => $request->serial,
                'device_name'   => $request->device_name,
                'date'   => $request->date,
                'updated_by'   => Auth::user()->id,
            ]);
            Toastr::success('Asset updated successfully.','Success');
            DB::commit();
            return redirect('admin/asset');
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
            Asset::destroy($request->id);
            Toastr::success('Asset deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Asset delete fail.','Error');
            return redirect()->back();
        }
    }

    public function import(Request $request){
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
            $extension = $request->file('file')->extension();
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                Excel::import(new AssetImport, $request->file('file'));
            }
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
