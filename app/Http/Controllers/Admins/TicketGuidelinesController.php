<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\TicketGuideline;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketGuidelinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Knowledgebase');
    }
    public function index()
    {
        $department = Department::orderBy('id', 'DESC')->get();
        $datas = TicketGuideline::get();
        return view('TicketGuidelines.index',compact('department', 'datas'));
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
            if($request->hasFile('attachments')) {
                $image = $request->file('attachments');
                $AttachmentName = $image->getClientOriginalName();
                $image->move(public_path('storage/attachments/'), $AttachmentName);
                $data['attachments'] = $AttachmentName;
            }
            $data['created_by'] = Auth::user()->id;
            // dd($data);
            TicketGuideline::create($data);
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
    public function edit(Request $request)
    {
        $department = Department::orderBy('id', 'DESC')->get();
        $data = TicketGuideline::where('id',$request->id)->first();
        return response()->json([
            'success'=>$data,
            'department'=>$department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            $data = $request->all();
            if($request->hasFile('attachments')) {
                $image = $request->file('attachments');
                $AttachmentName = $image->getClientOriginalName();
                $image->move(public_path('storage/attachments/'), $AttachmentName);
                $data['attachments']                = $AttachmentName;
            }
            $data['title']                      = $request->title;
            $data['remark']                     = $request->remark;
            $data["department_id"]              = $request->department_id;
            $data["branch_id"]                  = $request->branch_id;
            $data['updated_by']                 = Auth::user()->id;
            $Guideline = TicketGuideline::find($request->id);
            if ($Guideline) {
                $Guideline->update($data);
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
    public function destroy(Request $request)
    {
        try{
            TicketGuideline::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
