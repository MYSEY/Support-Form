<?php

namespace App\Http\Controllers\Admins;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Room::all();
        return view('rooms.index',compact('data'));
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
            Room::create($data);
            Toastr::success('Room create successfully.','Success');
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
            $data = Room::find($id);
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
            Room::where('id',$request->id)->update([
                'name'  => $request->name,
                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Updated room successfully.','Success');
            return redirect('admin/room');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated room fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            Room::destroy($request->id);
            Toastr::success('Room deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Room delete fail.','Error');
            return redirect()->back();
        }
    }
}
