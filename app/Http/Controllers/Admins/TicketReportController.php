<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Priority;
use App\Models\CustomStatus;
use Illuminate\Http\Request;
use App\Exports\TicketExport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $user = User::select('id','name')->get();
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
            )->where('tickets.deleted_at',null)
            ->when($request->priority, function ($query, $priority) {
                $query->where('tickets.priority', $priority);
            })->when($request->status, function ($query, $status) {
                $query->whereIn('tickets.status', $status);
            })->when($request->user_id, function ($query, $user_id) {
                $query->where('tickets.created_by', $user_id);
            });

            if ($from_date && $to_date) {
                $query->whereBetween('tickets.updated_at',  [$from_date, Carbon::parse($to_date)->endOfDay()]);
            }
            // Apply additional filtering for 'Staff' role
            if (Auth::user()->RolePermission == 'Staff') {
                $query->where('tickets.created_by',Auth::user()->id);
            }
            if (Auth::user()->RolePermission == 'admin_branch') {
                $query->where('tickets.branch_id', Auth::user()->branch_id);
            }

            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('tickets.trackid', 'like', "%{$searchValue}%")
                    ->orWhere('custom_statuses.name',$searchValue)
                    ->orWhere('tickets.name', 'like', "%{$searchValue}%")
                    ->orWhere('tickets.subject', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('users.name', 'like', "%{$searchValue}%")
                    ->orWhere('issue_types.name', 'like', "%{$searchValue}%")
                    ->orWhere('priorities.name', 'like', "%{$searchValue}%");
                });
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

        return view('reports.ticket', compact("status", "priority",'user'));
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
