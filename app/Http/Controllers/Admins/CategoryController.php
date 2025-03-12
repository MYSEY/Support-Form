<?php

namespace App\Http\Controllers\Admins;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Imports\CategoryImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::orderBy('id','DESC')->get();
        $data = Category::leftJoin('tasks','categories.task_id','=','tasks.id')
        ->select(
            'categories.*',
            'tasks.name as task_name',
            'tasks.description',
        )->orderBy('categories.task_id','DESC')->get();
        return view('category.index',compact('task','data'));
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
            Category::create($data);
            Toastr::success('Category create successfully.','Success');
            return redirect()->back();
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
        try{
            $data = Category::find($id);
            return response()->json(['success'=>$data]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
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
        try{
            Category::where('id',$request->id)->update([
                'task_id'  => $request->task_id,
                'name'  => $request->name,
                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Category updated successfully.','Success');
            return redirect('admin/category');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated task fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            Category::destroy($request->id);
            Toastr::success('Category deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Category delete fail.','Error');
            return redirect()->back();
        }
    }
    public function import(Request $request){
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
            $extension = $request->file('file')->extension();
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                Excel::import(new CategoryImport, $request->file('file'));
            }
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
