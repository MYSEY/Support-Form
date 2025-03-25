<?php

namespace App\Http\Controllers\Admins;

use App\Models\Asset;
use App\Models\CategoryTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        //
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