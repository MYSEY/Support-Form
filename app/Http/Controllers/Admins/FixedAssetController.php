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
    public function index(Request $request)
    {
        // Fetch assets from the default database
        $assets = Asset::orderBy('id','asc')->get();
        // Fetch users from the HRMS database
        $employees = DB::connection('mysqlhrconnection')->table('users')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->select(
            'number_employee', 
            'employee_name_kh', 
            'employee_name_en',
            'positions.name_english'
        )->get();
        // Merge users into assets
        $data = $assets->map(function ($asset) use ($employees) {
            $employee = $employees->get($asset->end_user);
            $asset->employee = $employee ? [
                'number_employee'   => $employee->number_employee,
                'employee_name_kh'  => $employee->employee_name_kh,
                'employee_name_en'  => $employee->employee_name_en,
                'name_english'  => $employee->name_english,
            ] : null;
            return $asset;
        });
        // $data = Asset::orderBy('id','asc')->get();
        return view('asset.index',compact('data'));
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
