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
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('maintenances')
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
        )->get();
        // dd($data);
        return view('maintenance.index',compact('data'));
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
                'message' => 'Maintenance record created successfully!',
                'maintenance' => $maintenance
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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