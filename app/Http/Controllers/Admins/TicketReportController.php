<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TicketReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = DB::table('hesk_tickets')
        // ->leftJoin('departments','hesk_tickets.category','=','departments.id')
        // ->leftJoin('priorities','hesk_tickets.priority','=','priorities.id')
        // ->leftJoin('users','hesk_tickets.owner','=','users.id')
        // ->leftJoin('custom_statuses','hesk_tickets.status','=','custom_statuses.id')
        // ->select(
        //     'hesk_tickets.*',
        //     'departments.name_khmer',
        //     'departments.name_english',
        //     'priorities.name as priorities_name',
        //     'users.user as owner',
        //     'custom_statuses.name as status',
        // )->OrderBy('hesk_tickets.id','DESC')->get();
        return view('reports.ticket');
    }

    public function search(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        
        $data = DB::table('hesk_tickets')
        ->leftJoin('departments','hesk_tickets.category','=','departments.id')
        ->leftJoin('users','hesk_tickets.owner','=','users.id')
        ->select(
            'hesk_tickets.id',
            'hesk_tickets.trackid',
            'hesk_tickets.name',
            'hesk_tickets.status',
            'hesk_tickets.email',
            'hesk_tickets.category',
            'hesk_tickets.priority',
            'hesk_tickets.subject',
            'hesk_tickets.dt',
            'hesk_tickets.owner',
            'hesk_tickets.custom1',
            'hesk_tickets.custom2',
            'departments.name_khmer as cate_name',
            'users.name as owner_name'
        )->when($request->priority, function ($query, $priority) {
            $query->where('hesk_tickets.priority', $priority);
        })->when($from_date, function ($query, $from_date) {
            $query->where('hesk_tickets.dt','>=', $from_date);
        })->when($to_date, function ($query, $to_date) {
            $query->where('hesk_tickets.dt','<=', $to_date);
        })->when($request->status, function ($query, $status) {
            $query->whereIn('hesk_tickets.status', $status);
        })->OrderBy('hesk_tickets.id','DESC')->get();
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
        $data = DB::table('hesk_tickets')
        ->leftJoin('departments','hesk_tickets.category','=','departments.id')
        ->leftJoin('priorities','hesk_tickets.priority','=','priorities.id')
        ->leftJoin('users','hesk_tickets.owner','=','users.id')
        ->leftJoin('custom_statuses','hesk_tickets.status','=','custom_statuses.id')
        ->select(
            'hesk_tickets.*',
            'departments.name_khmer',
            'departments.name_english',
            'priorities.name as priorities_name',
            'users.user as owner',
            'custom_statuses.name as status',
        )->OrderBy('hesk_tickets.id','DESC')->get();
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
}
