<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Branch;
use App\Models\Ticket;
use App\Models\Priority;
use App\Models\IssueType;
use App\Models\Department;
use App\Models\CustomStatus;
use Illuminate\Http\Request;
use App\Traits\GeneratingTicketID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    use GeneratingTicketID;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch = Branch::get();
        $department = Department::get();
        $data_tickets = Ticket::with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedBy")
        ->with("priorities")->with("createdBy")->get();
        return view('tickets.index', compact('data_tickets','department', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $issuetype= IssueType::orderBy('id','DESC')->get();
        $user_support = User::where("autoassign",1)->get();
        $priority= Priority::get();
        return view('tickets.form-create-ticket', compact('issuetype', 'priority','user_support'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $status = CustomStatus::orderBy('id', 'asc')->first();
            $data = $request->all();
            $data['trackid'] = $this->generateTicketID();
            $data['issue_type'] = json_encode($request->issue_type);
            $data['status'] = $status->id;
            $data['created_by'] = Auth::user()->id;
            Ticket::create($data);
            return response()->json([
                'message' => "Ticket created successfully.",
                'status'=>"success"
            ]);
            DB::commit();
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data_tickets = Ticket::with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedBy")
        ->with("priorities")->with("createdBy")
        ->when($request->status, function ($query, $status) {
            if ($status == 2) {
                $query->where("assignedby", Auth::user()->id);
            }
            if ($status == 3) {
                $query->whereNotIn("assignedby", ["unassigned","auto-assign"]);
            }
            if ($status == 4) {
                $query->whereIn("assignedby", ["unassigned","auto-assign"]);
            }
            if ($status == 5) {
                $currentDate = Carbon::now()->format('Y-m-d');
                $query->where('due_date', '>=',$currentDate);
            }
            if ($status == 6) {
                $currentDate = Carbon::now()->format('Y-m-d');
                $query->where('due_date', '<',$currentDate);
            }
        })
        ->get();
        DB::commit();
        return response()->json([
            'datas'=>$data_tickets
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('tickets.form-edit-ticket');
    }

    public function detail(Request $request)
    {
        $branch = Branch::get();
        $department = Department::get();
        $department = Department::get();
        $priority= Priority::get();
        $status = CustomStatus::orderBy('id', 'asc')->get();
        $user_support = User::where("autoassign",1)->get();
        $data_ticket = Ticket::with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedBy")
        ->with("priorities")->with("createdBy")
        ->where("id", $request->id)
        ->first();
        return view('tickets.ticket-detail', compact('data_ticket','status','branch', 'department', 'priority', 'user_support'));
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
