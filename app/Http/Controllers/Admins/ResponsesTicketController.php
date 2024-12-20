<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ResponsesTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ResponsesTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        RolePermission($this, 'Responses Ticket');
    }

    public function index()
    {
        $department = Department::orderBy('id', 'DESC')->get();
        $datas = ResponsesTicket::with("department")->get();
        return view('ResponsesTickets.index', compact('department', 'datas'));
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
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            // dd($data);
            ResponsesTicket::create($data);
            DB::commit();
            Toastr::success('Created successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            //  return response()->json(['errors' => $exp]);
            Toastr::error('Created fail','Error');
            return redirect()->back();
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
        $department = Department::orderBy('id', 'DESC')->get();
        $data = ResponsesTicket::where('id',$id)->first();
        return response()->json([
            'success'=>$data,
            'department'=>$department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $data = $request->all();
            $data['title']                      = $request->title;
            $data['message']                     = $request->message;
            $data["department_id"]              = $request->department_id;
            $data["branch_id"]                  = $request->branch_id;
            $data['updated_by']                 = Auth::user()->id;
            $Responses = ResponsesTicket::find($request->id);
            if ($Responses) {
                $Responses->update($data);
            }
            Toastr::success('Updated successfully.','Success');
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            ResponsesTicket::destroy($id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
