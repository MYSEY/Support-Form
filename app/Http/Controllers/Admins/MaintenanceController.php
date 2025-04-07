<?php

namespace App\Http\Controllers\Admins;

use App\Models\Asset;
use App\Models\Employee;
use App\Models\Maintenance;
use App\Models\CategoryTask;
use Illuminate\Http\Request;
use App\Models\MaintenanceDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            // Define the base query
            $query = DB::table('maintenances')
            ->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
            ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
            ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id')
            ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
            ->select(
                'maintenances.*', 
                'assets.serial', 
                'assets.device_name', 
                'categories.name as category_name', 
                'users.number_employee', 
                'users.employee_name_kh', 
                'users.employee_name_en',
                'positions.name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'rooms.name as location',
            )->where('maintenances.deleted_at',null);
            
            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('assets.serial', 'like', "%{$searchValue}%")
                    ->orWhere('assets.device_name', 'like', "%{$searchValue}%")
                    ->orWhere('users.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('categories.name', 'like', "%{$searchValue}%")
                    ->orWhere('rooms.name', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%");
                });
            }
            
            // Fetch paginated data
            $recordsTotal = Maintenance::where('id', Auth::user()->id)->count();
            $recordsFiltered = $query->count();
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->orderBy('maintenances.id', 'DESC')->offset($start)->limit($limit)->get();
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }

        return view('maintenance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $serial = Asset::all();
        return view('maintenance.create',compact('serial'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $maintenance = Maintenance::create($data);
            if (!empty($request->maintenaceDetail)) { // Ensure maintenaceDetail exists
                foreach ($request->maintenaceDetail as $value) {
                    MaintenanceDetail::create([
                        'maintenance_id' => $maintenance->id,
                        'task_id' => $value['task_id'], // Use array notation for JSON request
                        'note' => $value['note'],
                        'created_by' => Auth::id(),
                    ]);
                }
            }
            
            DB::commit();
            return response()->json([
                'message' => 'Maintenance record created successfully!'
            ], 201);
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Maintenance::with(['maintenanceDetail.task:id,name,type'])->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
        ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
        ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
        ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id')
        ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
        ->select(
            'maintenances.*', 
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
            'rooms.name as location',
        )->where('maintenances.id',$id)->first();
        return view('maintenance.detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Maintenance::with('maintenanceDetail')
        ->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
        ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
        ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
        ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id')
        ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
        ->select(
            'maintenances.*', 
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
            'rooms.name as location',
        )->where('maintenances.id',$id)->first();
        $serial = Asset::all();

        // Get the IDs of tasks that are already associated with this maintenance
        // $selectedTaskIds = $data->maintenanceDetail->pluck('task_id')->toArray();
        $selectedTaskIds = $data->maintenanceDetail->map(function($detail) {
            return [
                'task_id' => $detail->task_id,
                'note' => $detail->note
            ];
        });
        // Retrieve both Hardware & Software tasks
        $tasks = CategoryTask::leftJoin('tasks', 'category_tasks.task_id', '=', 'tasks.id')
        ->leftJoin('categories', 'categories.id', '=', 'category_tasks.category_id')
        ->select(
            'category_tasks.*',
            'categories.name as category_name',
            'tasks.id as task_id',
            'tasks.name as task_name',
            'tasks.type',
            'tasks.description'
        )->where('category_tasks.category_id', $data->category_id)->whereNull('category_tasks.deleted_at')->whereNull('tasks.deleted_at')->get();
        // Split tasks into Hardware & Software
        $hardwareTasks = $tasks->where('type', 'Hardware');
        $softwareTasks = $tasks->where('type', 'Software');
        return view('maintenance.edit',compact('data','serial','hardwareTasks', 'softwareTasks', 'selectedTaskIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $maintenance = Maintenance::findOrFail($id);
            $maintenance->update([
                'asset_id' => $request->asset_id,
                'asset_id' => $request->asset_id,
                'maintenance_date' => $request->maintenance_date,
                'maintenace_by' => $request->maintenace_by,
                'description' => $request->description,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        
            // Handle maintenance details
            $maintenance->maintenanceDetail()->delete(); // Remove old records
            foreach ($request->maintenaceDetail as $detail) {
                $maintenance->maintenanceDetail()->create([
                    'task_id' => $detail['task_id'],
                    'note' => $detail['note'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }
            
            DB::commit();
            return response()->json([
                'message' => 'Maintenance updated successfully!'
            ], 201);
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
            $maintenance = Maintenance::findOrFail($request->id);
            // Delete related maintenance details
            $maintenance->maintenanceDetail()->delete();
            // Delete the main maintenance record
            $maintenance->delete();
            Toastr::success('Maintenance deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Maintenance delete fail.','Error');
            return redirect()->back();
        }
    }

    public function OnChangeSerial(Request $request){
        $serial = $request->serial;
        $data = DB::table('assets') // Default database
        ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id') // Second database
        ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
        ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
        ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
        ->select(
            'assets.*',
            'users.employee_name_en',
            'users.employee_name_kh',
            'categories.name as category_name',
            'rooms.name as location',
            'positions.name_english',
            'branchs.branch_name_en',
        )->where('assets.id',$serial)->first();
        $task = CategoryTask::leftJoin('tasks','category_tasks.task_id','=','tasks.id')
        ->leftJoin('categories','categories.id','=','category_tasks.category_id')
        ->select(
            'category_tasks.*',
            'categories.name as category_name',
            'tasks.name as task_name',
            'tasks.type',
            'tasks.description',
        )->where('category_tasks.category_id',$data->category_id)->whereNull('category_tasks.deleted_at')->whereNull('tasks.deleted_at')->get();
        return response()->json(['message' => $data,'task'=>$task]);
    }
}