<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Exports\TicketExport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TicketReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = DB::table('tickets')
        // ->leftJoin('departments','tickets.category','=','departments.id')
        // ->leftJoin('priorities','tickets.priority','=','priorities.id')
        // ->leftJoin('users','tickets.owner','=','users.id')
        // ->leftJoin('custom_statuses','tickets.status','=','custom_statuses.id')
        // ->select(
        //     'tickets.*',
        //     'departments.name_khmer',
        //     'departments.name_english',
        //     'priorities.name as priorities_name',
        //     'users.user as owner',
        //     'custom_statuses.name as status',
        // )->OrderBy('tickets.id','DESC')->get();
        return view('reports.ticket');
    }

    public function search(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        
        $data = DB::table('tickets')
        // ->leftJoin('departments','tickets.department_id','=','departments.id')
        ->leftJoin('users','tickets.owner','=','users.id')
        ->select(
            'tickets.id',
            'tickets.trackid',
            'tickets.name',
            'tickets.status',
            'tickets.email',
            'tickets.priority',
            'tickets.subject',
            'tickets.dt',
            'tickets.owner',
            'tickets.custom1',
            // 'departments.name_khmer as cate_name',
            'users.name as owner_name'
        )->when($request->priority, function ($query, $priority) {
            $query->where('tickets.priority', $priority);
        })->when($from_date, function ($query, $from_date) {
            $query->where('tickets.dt','>=', $from_date);
        })->when($to_date, function ($query, $to_date) {
            $query->where('tickets.dt','<=', $to_date);
        })->when($request->status, function ($query, $status) {
            $query->whereIn('tickets.status', $status);
        })->OrderBy('tickets.id','DESC')->get();
        return response()->json([
            'success'=>$data,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = DB::table('tickets')
        ->leftJoin('departments','tickets.department_id','=','departments.id')
        ->leftJoin('priorities','tickets.priority','=','priorities.id')
        ->leftJoin('users','tickets.owner','=','users.id')
        ->leftJoin('custom_statuses','tickets.status','=','custom_statuses.id')
        ->select(
            'tickets.*',
            'departments.name_khmer',
            'departments.name_english',
            'priorities.name as priorities_name',
            'users.user as owner',
            'custom_statuses.name as status',
        )->OrderBy('tickets.id','DESC')->get();
        return response()->json([
            'success'=>$data,
        ]);
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

    public function export(Request $request){
        return Excel::download(new TicketExport($request), 'ticket-report.xlsx');
    }
}
