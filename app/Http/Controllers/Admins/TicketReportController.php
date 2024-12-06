<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Exports\TicketExport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CustomStatus;
use App\Models\Priority;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TicketReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Ticket Report');
    }

    public function index(Request $request)
    {
        $status = CustomStatus::get();
        $priority = Priority::get();
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        if (request()->ajax()) {
            // Define the base query
            $query = DB::table('tickets')
            ->leftJoin('departments','tickets.department_id','=','departments.id')
            ->leftJoin('branchs','tickets.branch_id','=','branchs.id')
            ->leftJoin('custom_statuses','tickets.status','=','custom_statuses.id')
            ->leftJoin('users','tickets.owner','=','users.id')
            ->leftJoin('issue_types','tickets.issue_type','=','issue_types.id')
            ->leftJoin('priorities','tickets.priority','=','priorities.id')
            ->select(
                'tickets.*',
                'departments.name_khmer',
                'departments.name_english',
                'branchs.branch_name_en',
                'branchs.branch_name_kh',
                'custom_statuses.name as status_name',
                'custom_statuses.color',
                'users.name as owner_name',
                'users.name as lastreplier',
                'users.name as assign_by',
                'issue_types.name as issue_type_name',
                'priorities.name as prioritie_name',
                'priorities.color as priority_color',
            )->when($request->priority, function ($query, $priority) {
                $query->where('tickets.priority', $priority);
            })->when($request->status, function ($query, $status) {
                $query->whereIn('tickets.status', $status);
            });

            if ($from_date && $to_date) {
                $query->whereBetween('tickets.dt',  [$from_date, Carbon::parse($to_date)->endOfDay()]);
            }
            // Apply additional filtering for 'Staff' role
            if (Auth::user()->RolePermission == 'Staff') {
                $query->where('tickets.created_by',Auth::user()->id);
            }

            // Fetch paginated data
            $recordsTotal = Ticket::where('id', Auth::user()->id)->count();
            $recordsFiltered = $query->count();
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->orderBy('tickets.id', 'DESC')->offset($start)->limit($limit)->get();
            
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }

        return view('reports.ticket', compact("status", "priority"));
    }

    public function search(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        
        $query = Ticket::
        with("fromDepartment")
        ->with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedBy")
        ->with("priorities")->with("createdBy")
        ->with("issueType")->with("assignedTo")
        
        ->when($request->priority, function ($query, $priority) {
            $query->where('tickets.priority', $priority);
        })->when($from_date, function ($query, $from_date) {
            $query->where('tickets.dt','>=', $from_date);
        })->when($to_date, function ($query, $to_date) {
            $query->where('tickets.dt','<=', $to_date);
        })->when($request->status, function ($query, $status) {
            $query->whereIn('tickets.status', $status);
        });

        // Apply additional filtering for role
        // if (Auth::user()->RolePermission=='staff') {
        //     $query->where('department_id',Auth::user()->department_id);
        // }
        if (Auth::user()->RolePermission=='staff') {
            $query->where("created_by", Auth::user()->id);
        }else if(Auth::user()->RolePermission=='admin_support'){
            $query->where('department_id', Auth::user()->department_id)
            ->orWhere("created_by", Auth::user()->id)
            ->orWhere("owner", Auth::user()->id);
        }else if(Auth::user()->RolePermission=='admin'){
            $query->where('department_id', Auth::user()->department_id)
            ->orWhere('department_id_from', Auth::user()->department_id);
        }else if(Auth::user()->RolePermission=="admin_branch"){
            $query->where('branch_id', Auth::user()->branch_id);
        }
        $data = $query->OrderBy('tickets.id','DESC')->get();
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
        
        $data = Ticket::
        with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedTo")
        ->with("priorities")->with("createdBy")
        ->with("fromDepartment")
        ->with("issueType");
        if (Auth::user()->RolePermission=='staff') {
            $data->where("created_by", Auth::user()->id)->get();
        }else if(Auth::user()->RolePermission=='admin_support'){
            $data->where('department_id', Auth::user()->department_id)
            ->orWhere("created_by", Auth::user()->id)
            ->orWhere("owner", Auth::user()->id)
            ->get();
        }else if(Auth::user()->RolePermission=='admin'){
            $data->where('department_id', Auth::user()->department_id)
            ->orWhere('department_id_from', Auth::user()->department_id)
            ->get();
        }else if(Auth::user()->RolePermission=="admin_branch"){
            $data->where('branch_id', Auth::user()->branch_id)
            ->get();
        }else{
            $data->get();
        }

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
