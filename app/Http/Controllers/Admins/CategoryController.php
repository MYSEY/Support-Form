<?php

namespace App\Http\Controllers\Admins;

use App\Models\Task;
use App\Models\Category;
use App\Models\CategoryTask;
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
        $task = Task::whereNull('deleted_at')->get();
        // $data = CategoryTask::leftJoin('tasks','category_tasks.task_id','=','tasks.id')
        // ->leftJoin('categories','categories.id','=','category_tasks.category_id')
        // ->select(
        //     'category_tasks.*',
        //     'categories.name as category_name',
        //     'tasks.name as task_name',
        //     'tasks.description',
        //     'tasks.type',
        // )->whereNull('category_tasks.deleted_at')->whereNull('tasks.deleted_at')->orderBy('categories.id','DESC')->get();
        $data = Category::all();
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
            DB::beginTransaction();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $category = Category::create($data);
            foreach ($request->task as $value) {
                CategoryTask::create([
                    'category_id' => $category->id, 
                    'task_id' => $value, 
                    'created_by' => Auth::user()->id, 
                ]);
            }
            DB::commit();
            Toastr::success('Category create successfully.','Success');
            return redirect()->back();
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
            $data = Category::with(['categoryTasks.task' => function($query) {
                $query->select('id', 'name', 'description', 'type');
            }])->findOrFail($id);
            // Group tasks by type
            $groupedTasks = $data->categoryTasks->groupBy(function($task) {
                return $task->task->type; // Group by task type
            });
            return view('category.detail',compact('data','groupedTasks'));
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $data = Category::with('categoryTasks.task')->where('id', $id)->first();
            return response()->json(['success'=>$data]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction(); // Start the transaction
        try{
            Category::where('id', $request->category_id)->update([
                'name' => $request->name,
                'updated_by' => Auth::user()->id,
            ]);
            // Step 2: Delete old CategoryTask records
            CategoryTask::where('category_id', $request->category_id)->delete();
            // Step 3: Insert new CategoryTask for each task_id
            foreach ($request->task as $task_id) {
                CategoryTask::create([
                    'category_id' => $request->category_id,
                    'task_id' => $task_id,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
            }
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
            DB::beginTransaction(); // Start Transaction
            CategoryTask::where('task_id', $request->id)->delete();
            
            DB::commit(); // Commit Transaction
            Toastr::success('Category deleted successfully.', 'Success');
            return redirect()->back();
            // Category::destroy($request->id);
            // Toastr::success('Category deleted successfully.','Success');
            // return redirect()->back();
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
