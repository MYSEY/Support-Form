<?php

namespace App\Http\Controllers\Admins;

use App\Models\Room;
use App\Models\Asset;
use App\Models\Branch;
use App\Models\Category;
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
        // if (request()->ajax()) {
        //     // Define the base query
        //     $query = DB::table('assets')
        //     ->leftJoin('categories','assets.category_id','=','categories.id')
        //     ->leftJoin('branchs','assets.office','=','branchs.id')
        //     ->leftJoin('rooms','assets.location','=','rooms.id')
        //     ->select(
        //         'assets.*',
        //         'categories.name as cate_name',
        //         'branchs.branch_name_en as office',
        //         'rooms.name as location',
        //         DB::raw("
        //             CASE 
        //                 WHEN assets.lifecycle_month >= 60 THEN 
        //                     CONCAT(FLOOR(assets.lifecycle_month / 12), ' Years ', MOD(assets.lifecycle_month, 12), ' Months')
        //                 ELSE 
        //                     CONCAT(assets.lifecycle_month, ' Months')
        //             END as lifecycle_month
        //         ")
        //     )->where('assets.deleted_at',null);
            
        //     // **Search Handling**
        //     $searchValue = request()->input('search.value');
        //     if (!empty($searchValue)) {
        //         $query->where(function ($q) use ($searchValue) {
        //             $q->where('assets.id', 'like', "%{$searchValue}%")
        //             ->orWhere('assets.name',$searchValue)
        //             ->orWhere('assets.type',$searchValue)
        //             ->orWhere('assets.description', 'like', "%{$searchValue}%");
        //         });
        //     }
        //     // **Sorting Handling**
        //     if ($request->has('order')) {
        //         $orderColumnIndex = $request->input('order.0.column'); // Column index
        //         $orderColumnName = $request->input('columns.' . $orderColumnIndex . '.data'); // Column name
        //         $orderDirection = $request->input('order.0.dir'); // Sort direction (asc or desc)
        
        //         // Dynamically sort by the column name
        //         if (!empty($orderColumnName)) {
        //             $query->orderBy($orderColumnName, $orderDirection);
        //         }
        //     }
            
        //     // **Pagination Handling**
        //     $recordsTotal = DB::table('assets')->where('assets.deleted_at',null)->count(); // Total records
        //     $recordsFiltered = $query->count(); // Filtered records
            
        //     // Apply pagination for the actual data retrieval
        //     $start = intval($request->input('start', 0));
        //     $limit = intval($request->input('length', 10));
        //     $data = $query->offset($start)->limit($limit)->get();
            
        //     // Return JSON response
        //     return response()->json([
        //         'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
        //         'recordsTotal' => $recordsTotal,
        //         'recordsFiltered' => $recordsFiltered,
        //         'data' => $data
        //     ]);
        // }
        $data = Asset::orderBy('id','asc')->get();
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
        $users = DB::table('users')->get();
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
        $users = DB::table('users')->get();
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
        // try{
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
            $extension = $request->file('file')->extension();
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                Excel::import(new AssetImport, $request->file('file'));
            }
            return response()->json(['mg'=>'success'], 200);
        // }catch(\Exception $e){
        //     return response()->json(['error'=>$e->getMessage()]);
        // }
    }
}
