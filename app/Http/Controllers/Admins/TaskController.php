<?php

namespace App\Http\Controllers\Admins;

use App\Models\Task;
use App\Imports\TaskImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Task');
    }
    public function index(Request $request)
    {
        if (request()->ajax()) {
            // Define the base query
            $query = DB::table('tasks')
            ->select(
                'tasks.*',
            )->where('tasks.deleted_at',null);
            
            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('tasks.id', 'like', "%{$searchValue}%")
                    ->orWhere('tasks.name',$searchValue)
                    ->orWhere('tasks.type',$searchValue)
                    ->orWhere('tasks.description', 'like', "%{$searchValue}%");
                });
            }
            // **Sorting Handling**
            if ($request->has('order')) {
                $orderColumnIndex = $request->input('order.0.column'); // Column index
                $orderColumnName = $request->input('columns.' . $orderColumnIndex . '.data'); // Column name
                $orderDirection = $request->input('order.0.dir'); // Sort direction (asc or desc)
        
                // Dynamically sort by the column name
                if (!empty($orderColumnName)) {
                    $query->orderBy($orderColumnName, $orderDirection);
                }
            }
            
            // **Pagination Handling**
            $recordsTotal = DB::table('tasks')->where('tasks.deleted_at',null)->count(); // Total records
            $recordsFiltered = $query->count(); // Filtered records
            
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->offset($start)->limit($limit)->get();
            
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        return view('tasks.index');
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
            Task::create($data);
            Toastr::success('Task create successfully.','Success');
            return redirect()->back();
            DB::commit();
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
            $data = Task::find($id);
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            Task::where('id',$request->id)->update([
                'name'  => $request->name,
                'type'  => $request->type,
                'description'  => $request->description,
                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Task updated successfully.','Success');
            return redirect('admin/task');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated task fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            Task::destroy($request->id);
            Toastr::success('Task deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Task delete fail.','Error');
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
                Excel::import(new TaskImport, $request->file('file'));
            }
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
