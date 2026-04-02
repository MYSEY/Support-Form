<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassificationIssue;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassificationIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ClassificationIssue::orderBy('id','DESC')->where("department_id",Auth::user()->department_id)->get();
        return view('classification_issues.index', compact('data'));
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
            $data['department_id'] = Auth::user()->department_id;
            ClassificationIssue::create($data);
            Toastr::success('Classification issue created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function showId(Request $request){
        $data = ClassificationIssue::when($request, function ($query, $request) {
            if ($request->department_id) {
                $query->where("department_id", $request->department_id);
            }
            if ($request->branch_id) {
                $query->where("branch_id", $request->branch_id);
            }
        })->get();
        return response()->json([
            'data' => $data,
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
    public function update(Request $request)
    {
        try{
            $data = ClassificationIssue::find($request->id);
            $data['name']  = $request->name;
            $data['color']  = $request->color;
            $data['updated_by']  = Auth::user()->id;
            $data->save();
            Toastr::success('Classification issue updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Classification issue updated fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            ClassificationIssue::destroy($request->id);
            Toastr::success('Classification issue deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Classification issue delete fail.','Error');
            return redirect()->back();
        }
    }
}
