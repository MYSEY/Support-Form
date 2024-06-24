<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\IssueType;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Auth::user()->branch_id);
        $branch = Branch::get();
        $department = Department::get();
        $data_tickets = Ticket::with("department")->with("branch")->with("assignedby")->with("priorities")->with("createdBy")->get();
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
            $data = $request->all();
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('tickets.form-edit-ticket');
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
