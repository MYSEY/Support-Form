<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            $data['user_id'] = Auth::user()->id;
            $data['created_by'] = Auth::user()->id;
            Note::create($data);
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
        $data = Note::where("ticket_id",$request->ticket_id)->with("createdBy")
        ->get();
        DB::commit();
        return response()->json([
            'datas'=>$data
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
            $data = Note::find($request->id);
            $data['message']  = $request->message;
            $data['user_id'] = Auth::user()->id;
            $data['updated_by']  = Auth::user()->id;
            $data->save();
            Toastr::success('Updated successfully.','Success');
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
            Note::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Deleted fail.','Error');
            return redirect()->back();
        }
    }
}
