<?php

namespace App\Http\Controllers\Admins;

use App\Models\IssueType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IssueTypeRequest;
use App\Models\Branch;
use App\Models\Department;

class IssueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch = Branch::orderBy('id','DESC')->get();
        $department = Department::orderBy('id','DESC')->get();
        $data = IssueType::all();
        return view('issue_type.index',compact('branch','department','data'));
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
    public function store(IssueTypeRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            IssueType::create($data);
            DB::commit();
            // Toastr::success('Created Issue Type successfully.','Success');
            return response()->json([
                'message' => "Create created successfully.",
                'status'=>"success"
            ]);
            // return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
             return response()->json(['errors' => $exp]);
            // Toastr::error('Created Issue Type fail','Error');
            // return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = IssueType::where('id',$request->id)->first();
        $branch = Branch::orderBy('id','DESC')->get();
        $department = Department::orderBy('id','DESC')->get();
        return response()->json([
            'success'=>$data,
            'branch'=>$branch,
            'department'=>$department,
        ]);
    }

    public function dataSelect(Request $request)
    {
        $data = IssueType::when($request->department_id, function ($query, $department_id) {
            $query->where('department_id', $department_id);
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('branch_id', $branch_id);
        })->get();
        return response()->json([
            'data'=>$data
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
        try {
            IssueType::where('id',$request->id)->update([
                'name'          => $request->name,
                'type'          => $request->type,
                'req'           => $request->req,
                'category_type' => $request->category_type,
                'department_id' => $request->department_id,
                'branch_id'     => $request->branch_id,
                'value'         => $request->value,
                'updated_by'    => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json([
                'message' => "Update created successfully.",
                'status'=>"success"
            ]);
            // Toastr::success('Updated Issue Type successfully.','Success');
            // return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['errors' => $exp]);
            // Toastr::error('Updated Issue Type fail','Error');
            // return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            IssueType::destroy($request->id);
            Toastr::success('Issue Type deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Issue Type delete fail.','Error');
            return redirect()->back();
        }
    }
}
