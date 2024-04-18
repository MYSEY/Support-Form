<?php

namespace App\Http\Controllers\Admins;

use App\Models\IssueType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IssueTypeRequest;

class IssueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IssueType::all();
        return view('issue_type.index',compact('data'));
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
            Toastr::success('Created Issue Type successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created Issue Type fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = IssueType::where('id',$request->id)->first();
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
        try {
            IssueType::where('id',$request->id)->update([
                'name'    => $request->name,
                'updated_by'    => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Updated Issue Type successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Updated Issue Type fail','Error');
            return redirect()->back();
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
