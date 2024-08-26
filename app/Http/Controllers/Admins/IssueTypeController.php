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
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class IssueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        RolePermission($this, 'Issue Type');
    }
    public function index()
    {
        $department = Department::orderBy('id', 'DESC')->get();
        $data = IssueType::with("department")->get();
        return view('issue_type.index', compact('department', 'data'));
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
                'status' => "success"
            ]);
            // return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['errors' => $exp]);
            // Toastr::error('Created Issue Type fail','Error');
            // return redirect()->back();
        }
    }

    public function dataImport(Request $request)
    {
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $dataIssueType =  $spreadsheet->getSheetByName('issue_type')->toArray();

        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataDuplicate = [];
            foreach ($dataIssueType as $item) {
                $i++;
                if ($i > 2) {
                    $duplicateIssue = IssueType::where([['name',$item[1]],["department_id",$item[2]]])->get();
                    if (count($duplicateIssue) > 0) {
                        $dataDuplicate[]= $duplicateIssue;
                    }else{
                        $issue = IssueType::firstOrCreate([
                            'name'              => $item[1],
                            'category_type'     => 2,
                            'department_id'     => $item[2],
                            'created_by'        => Auth::user()->id
                        ]);
                    }
                }
            }
            if($dataDuplicate){
                return response()->json(['error'=>$dataDuplicate]);
            }
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = IssueType::where('id', $request->id)->first();
        $department = Department::orderBy('id', 'DESC')->get();
        return response()->json([
            'success' => $data,
            'department' => $department,
        ]);
    }

    public function showById(Request $request){

        $data = IssueType::when($request, function ($query, $request) {
            if ($request->department_id) {
                $query->where("department_id", $request->department_id);
            }
            if ($request->branch_id) {
                $query->where("branch_id", $request->branch_id);
            }
        })
        ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function duplicateIssueType(Request $request){
        try {
            $duplicate = IssueType::where([["name",$request->name], ["department_id",$request->department_id]])->first();
            DB::commit();
            if ($duplicate) {
                return ['message' => 'Issue type already exists', "data"=>1];
            }else{
                return ['message' => 'Issue type does not exist', "data"=>0];
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
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
            'data' => $data
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
            IssueType::where('id', $request->id)->update([
                'name'          => $request->name,
                'req'           => $request->req,
                'category_type' => $request->category_type,
                'department_id' => $request->department_id,
                'updated_by'    => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json([
                'message' => "Update created successfully.",
                'status' => "success"
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
        try {
            IssueType::destroy($request->id);
            Toastr::success('Issue Type deleted successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Issue Type delete fail.', 'Error');
            return redirect()->back();
        }
    }
}
