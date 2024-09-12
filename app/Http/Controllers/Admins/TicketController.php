<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon as Carbon;
use App\Models\User;
use App\Models\Email as ModelsMail;
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
use App\Models\TicketHistory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Reply;
use App\Models\TicketGuideline;

class TicketController extends Controller
{
    use GeneratingTicketID;

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Ticket');
    }
    public function index()
    {
        // $branch = Branch::get();
        $department = Department::where("status", "Active")->get();
        $status = CustomStatus::where("name", "Closed")->first();
        $currentDate = Carbon::now()->format('Y-m-d');
        $statusCondition = function ($query) use ($status) {
            $query->when($status, function ($query, $status) {
                $query->whereNot('status', $status->id);
            });
        };
        
        $departmentCondition = function ($query) {
            $query->when(Auth::user()->department_id, function ($query) {
                $query->where('department_id', Auth::user()->department_id);
                $query->orWhere("created_by", Auth::user()->id);
                $query->orWhere("assignedby", Auth::user()->id);
            });
        };
        $total_all_ticket = [];
        $total_assigned_ticket = [];
        $total_others_ticket = [];
        $total_unassigned_ticket = [];
        $total_due_soon_ticket = [];
        $total_overdue_ticket = [];
        if (Auth::user()->RolePermission=='staff') {
            $total_all_ticket = Ticket::where("created_by", Auth::user()->id)->count();
            // $total_assigned_ticket = Ticket::where("created_by", Auth::user()->id)->count();
            $total_due_soon_ticket = Ticket::where("created_by", Auth::user()->id)->where('due_date', '>=',$currentDate)->count();
            $total_overdue_ticket = Ticket::where("created_by", Auth::user()->id)->where('due_date', '<',$currentDate)->count();
        }else
        if (Auth::user()->RolePermission=='admin') {
            $total_all_ticket = Ticket::where($departmentCondition)->orWhere("assignedby", Auth::user()->id)
            // ->where($statusCondition)
            ->count();
            $total_assigned_ticket = Ticket::where("assignedby", Auth::user()->id)->count();
            // $total_others_ticket = Ticket::where($departmentCondition)->where($statusCondition)->whereNot("assignedby", Auth::user()->id)->count();
            $total_unassigned_ticket = Ticket::where($departmentCondition)
            // ->where($statusCondition)
            ->whereIn("assignedby", ["unassigned","auto-assign"])->count();
            $total_due_soon_ticket = Ticket::where($departmentCondition)
            // ->where($statusCondition)
            ->where('due_date', '>=',$currentDate)->count();
            $total_overdue_ticket = Ticket::where($departmentCondition)
            // ->where($statusCondition)
            ->where('due_date', '<',$currentDate)->count();
        }else {
            $total_all_ticket = Ticket::where($statusCondition)->count();
            $total_assigned_ticket = Ticket::where("assignedby", Auth::user()->id)
            // ->where($statusCondition)
            ->count();
            $total_others_ticket = Ticket::whereNot("assignedby", Auth::user()->id)
            // ->where($statusCondition)
            ->count();
            $total_unassigned_ticket = Ticket::where("assignedby", "unassigned")
            // ->where($statusCondition)
            ->count();
            $total_due_soon_ticket = Ticket::where('due_date', '>=',$currentDate)
            // ->where($statusCondition)
            ->count();
            $total_overdue_ticket = Ticket::where('due_date', '<',$currentDate)
            // ->where($statusCondition)
            ->count();
        }
        return view('tickets.index', compact(
            'total_all_ticket',
            'total_assigned_ticket',
            'total_others_ticket',
            'total_unassigned_ticket',
            'total_due_soon_ticket',
            'total_overdue_ticket',
            'department'
        ));
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
        DB::beginTransaction();
        try {
            $data = $request->all();
            if($request->hasFile('attachments')) {
                $image = $request->file('attachments');
                $AttachmentName = $image->getClientOriginalName();
                $image->move(public_path('storage/attachments/'), $AttachmentName);
                $data['attachments'] = $AttachmentName;
            }
            $status = CustomStatus::orderBy('id', 'asc')->first();
            $data['trackid'] = $this->generateTicketID();
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            // $data['department_id'] = $request->department_id;
            // $data['branch_id'] = $request->branch_id;
            $data['issue_type'] = $request->issue_type;
            $data['status'] = $status->id;
            $data['dt'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['created_by'] = Auth::user()->id;
            $ticket = Ticket::create($data);

            $data_histoies['trackid'] = $ticket->id;
            $data_histoies['type'] = "new";
            $data_histoies['created_by'] = Auth::user()->id;
            TicketHistory::create($data_histoies);

            // for send email
            $assigned_to = User::where("id", $request->assignedby)->first();

            $data_tickets = Ticket::where("id", $ticket->id)
            ->with("department")
            ->with("branch")->with("lastReplier")
            ->with("CustomStatus")->with("assignedBy")
            ->with("issueType")
            ->with("priorities")
            ->with("createdBy")
            ->with("updatedBy")
            ->first();
            $datasSendEmail = [
                "data_tickets"=> $data_tickets,
                "status"=> "new",
            ];
             
            //  $mail_message = ModelsMail::first();
            // if ($assigned_to) {
            //     if ($assigned_to->email) {
            //         Mail::to($assigned_to->email)->send(new SendMail($datasSendEmail));
            //     }
            // }
            // Mail::to("vibol.sok@camma.com.kh")->send(new SendMail($datasSendEmail));

            DB::commit();
            return response()->json([
                'message' => "Ticket created successfully.",
                'status'=>"success"
            ]);
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $status = CustomStatus::where("name", "Closed")->first();
        $statusCondition = function ($query) use ($status) {
            $query->when($status, function ($query, $status) {
                $query->whereNot('status', $status->id);
            });
        };
        
        $departmentCondition = function ($query) {
            $query->when(Auth::user()->department_id, function ($query) {
                $query->where('department_id', Auth::user()->department_id);
                $query->orWhere("created_by", Auth::user()->id);
                $query->orWhere("assignedby", Auth::user()->id);
            });
        };
        // dd($request->status);
        if (Auth::user()->RolePermission=='staff') {
            $data_tickets = Ticket::with("department")
            ->with("branch")->with("lastReplier")
            ->with("CustomStatus")->with("assignedBy")
            ->with("priorities")->with("createdBy")
            ->with("issueType")
            ->where("created_by", Auth::user()->id)
            ->when($request->status, function ($query, $status) {
                if ($status == 2) {
                    $query->where("assignedby", Auth::user()->id);
                }
                if ($status == 3) {
                    $query->whereNot("assignedby", Auth::user()->id);
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
            ->orderBy('id','DESC')
            ->get();
        }else if(Auth::user()->RolePermission=='admin'){
            $data_tickets = Ticket::with("department")
            ->with("branch")->with("lastReplier")
            ->with("CustomStatus")->with("assignedBy")
            ->with("priorities")->with("createdBy")
            ->with("issueType")
            ->where($departmentCondition)
            // ->where($statusCondition)
            ->when($request->status, function ($query, $status) {
                if ($status == 2) {
                    $query->where("assignedby", Auth::user()->id);
                }
                if ($status == 3) {
                    $query->whereNot("assignedby", Auth::user()->id);
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
            ->orderBy('id','DESC')
            ->get();
        }else {
            $data_tickets = Ticket::with("department")
            ->with("branch")->with("lastReplier")
            ->with("CustomStatus")->with("assignedBy")
            ->with("priorities")->with("createdBy")
            ->with("issueType")
            // ->where($statusCondition)
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
            ->orderBy('id','DESC')
            ->get();
        }
       
        DB::commit();
        return response()->json([
            'datas'=>$data_tickets
        ]);
    }
    public function showOne(Request $request)
    {
        $issuetype= IssueType::orderBy('id','DESC')->get();
        $Priority= Priority::orderBy('id','DESC')->get();
        $data_ticket = Ticket::where("id", $request->id)->first();
        DB::commit();
        return response()->json([
            'data'=>$data_ticket,
            'issuetype'=>$issuetype,
            'priority'=>$Priority,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('tickets.form-edit-ticket');
    }

    public function detail(Request $request)
    {
        $branch = Branch::get();
        $priority= Priority::get();
        $status = CustomStatus::orderBy('id', 'asc')->get();
        $user_support = User::where("autoassign",1)->get();
        $data_ticket = Ticket::with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedBy")
        ->with("priorities")->with("createdBy")
        ->with("issueType")
        ->with("histories")
        ->where("id", $request->id)
        ->first();
        return view('tickets.ticket-detail', compact('data_ticket','status', 'priority', 'user_support'));
    }

    public function viewGuidelines(Request $request){
        $datas = TicketGuideline::where("department_id", $request->id)->get();
        if (count($datas) > 0) {
            return view('tickets.view_ticket_guideline',compact('datas'));
        }else{
            $issuetype= IssueType::orderBy('id','DESC')->get();
            $user_support = User::where("autoassign",1)->get();
            $priority= Priority::get();
            return view('tickets.form-create-ticket', compact('issuetype', 'priority','user_support'));
        }
    }

    public function status(Request $request){
        try {
            $data = $request->all();
            $data = Ticket::find($request->id);
            $data_histoies['from_status'] = $data->status;

            $data['status'] = $request->status;
            $data['updated_by']     = Auth::user()->id;
            $data->save();
            $data_histoies['trackid'] = $data->id;
            $data_histoies['type'] = "status";
            $data_histoies['to_status'] = $request->status;
            $data_histoies['created_by'] = Auth::user()->id;
            TicketHistory::create($data_histoies);

            return response()->json([
                'message' => "Status update successfully.",
                'status'=>"success"
            ]);
            DB::commit();
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }
    public function priorities(Request $request){
        try {
            $data = $request->all();
            $data = Ticket::find($request->id);
            $data_histoies['from_priority_id'] = $data->priority;

            $data['priority'] = $request->priority;
            $data['updated_by']     = Auth::user()->id;
            $data->save();

            $data_histoies['trackid'] = $data->id;
            $data_histoies['type'] = "priority";
            $data_histoies['to_priority_id'] = $request->priority;
            $data_histoies['created_by'] = Auth::user()->id;
            TicketHistory::create($data_histoies);

            return response()->json([
                'message' => "Status update successfully.",
                'status'=>"success"
            ]);
            DB::commit();
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }
    public function assignedTo(Request $request){
        try {
            $data = $request->all();
            $data = Ticket::find($request->id);
            $data_histoies['assignedby'] = $data->assignedby;
            $data['assignedby'] = $request->assigned_to;
            $data['updated_by']     = Auth::user()->id;
            $data->save();

            $data_histoies['trackid'] = $data->id;
            $data_histoies['type'] = "assign";
            $data_histoies['recipient_id'] = $request->assigned_to;
            $data_histoies['created_by'] = Auth::user()->id;
            TicketHistory::create($data_histoies);

            return response()->json([
                'message' => "Update assigned to successfully.",
                'status'=>"success"
            ]);
            DB::commit();
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            if($request->hasFile('attachments')) {
                $image = $request->file('attachments');
                $AttachmentName = $image->getClientOriginalName();
                $image->move(public_path('storage/attachments/'), $AttachmentName);
            }else{
                $AttachmentName = $request->old_attachment;
            }
            $data = Ticket::find($request->id);
            $data['attachments'] = $AttachmentName;
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['department_id'] = Auth::user()->department_id;
            $data['branch_id'] = Auth::user()->branch_id;
            $data['subject']  = $request->subject;
            $data['issue_type']  = $request->issue_type;
            $data['priority']  = $request->priority;
            $data['message']  = $request->message;
            $data['dt'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['updated_by']  = Auth::user()->id;
            $data->save();

            // Toastr::success('Updated successfully.','Success');
            return response()->json([
                'message' => "Update data successfully.",
                'status'=>"success"
            ]);
        }catch(\Exception $e){
            DB::rollback();
            // Toastr::error('Updated fail.','Error');
            return redirect()->back();
        }
    }
    public function replies(Request $request)
    {
        DB::beginTransaction();
        try{
            $ticket_update = false;
            $data_assign = false;
            $dataHistoryStatus = [];
            $dataHistoryPriority = [];
            $data = Ticket::find($request->reply_to);
            $assigned_to = User::where("id", $request->assignedby)->first();
            // Add new history on status
            if ($data->status != $request->status) {
                $ticket_update = true;
                $data_histoies_status['trackid'] = $data->id;
                $data_histoies_status['type'] = "status";
                $data_histoies_status['from_status'] = $data->status;
                $data_histoies_status['to_status'] = $request->status;
                $data_histoies_status['created_by'] = Auth::user()->id;
                $historyStatus = TicketHistory::create($data_histoies_status);
                $dataHistoryStatus = TicketHistory::where("id", $historyStatus->id)->with("statusFrom")->with("statusTo")->first();

            }

            // Add new history on priority
            if ($data->priority !=  $request->priority) {
                $ticket_update = true;
                $data_histoies_priority['trackid'] = $data->id;
                $data_histoies_priority['type'] = "priority";
                $data_histoies_priority['from_priority_id'] = $data->priority;
                $data_histoies_priority['to_priority_id'] = $request->priority;
                $data_histoies_priority['created_by'] = Auth::user()->id;
                $historyPriority = TicketHistory::create($data_histoies_priority);
                $dataHistoryPriority = TicketHistory::where("id", $historyPriority->id)->with("priorityFrom")->with("priorityTo")->first();
            }
            
            if ($data->assignedby != $request->assignedby) {
                $ticket_update = true;
                $data_assign = true;
            }
            // Update ticket
            if ($ticket_update == true) {
                $data['assignedby']  = $request->assignedby;
                $data['status']  = $request->status;
                $data['priority']  = $request->priority;
                // $data['lastreplier']  = Auth::user()->id;
                // $data['updated_by']  = Auth::user()->id;
                // $data->save();
            }
            $data['lastreplier']  = Auth::user()->id;
            $data['updated_by']  = Auth::user()->id;
            $data->save();
            
            // Add new reply
            $dataReply['staff_id'] = Auth::user()->id;
            $dataReply['reply_to'] = $request->reply_to;
            $dataReply['message'] = $request->message;
            $dataReply['message_html'] = $request->message_html;
            $dataReply['name'] = Auth::user()->name;
            $dataReply['created_by'] = Auth::user()->id;
            $dataReply = Reply::create($dataReply);

            $data_tickets = Ticket::where("id", $data->id)
            ->with("department")
            ->with("branch")->with("lastReplier")
            ->with("CustomStatus")->with("assignedBy")
            ->with("issueType")
            ->with("priorities")
            ->with("createdBy")
            ->with("updatedBy")
            ->first();
            $datasSendEmail = [
                "data_assign"=> $data_assign,
                "data_tickets"=> $data_tickets,
                "status"=> "replies",
                "dataReply"=> $dataReply,
                "dataHistoryStatus"=> $dataHistoryStatus,
                "dataHistoryPriority"=> $dataHistoryPriority,
            ];
        
            // if (!$request->autoreload) {
            //     // $mail_message = ModelsMail::first();
            //     if ($assigned_to) {
            //         if ($assigned_to->email == Auth::user()->email) {
            //             Mail::to($data_tickets->createdBy->email)->send(new SendMail($datasSendEmail));
            //         }else if($data_tickets->createdBy->email == Auth::user()->email){
            //             Mail::to($assigned_to->email)->send(new SendMail($datasSendEmail));
            //         }else{
            //             Mail::to($assigned_to->email)->send(new SendMail($datasSendEmail));
            //         }
            //     }
            // }
            // Mail::to("vibol.sok@camma.com.kh")->send(new SendMail($datasSendEmail));
           
            // Toastr::success('Updated successfully.','Success');
            DB::commit();
            return response()->json([
                'message' => "Ticket replies successfully.",
                'status'=>"success"
            ]);
        }catch(\Exception $e){
            DB::rollback();
            // Toastr::error('Updated fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            Ticket::destroy($request->id);
            DB::commit();
            return response()->json([
                'message' => "Ticket deleted successfully.",
                'status'=>"success"
            ]);
            // Toastr::success('Ticket deleted successfully.','Success');
            // return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'message' => "Ticket delete fail.",
                'status'=>"Error"
            ]);
            // Toastr::error('Ticket delete fail.','Error');
            // return redirect()->back();
        }
    }
}
