<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = DB::table('users')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->leftJoin('departments','departments.id','=','users.department_id')
        ->select(
            'users.*',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'departments.name_english',
        )->get();
        return view('users.index', compact('data'));
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
            $request->validate(
                [
                    'password' => 'required',
                    'confirm_password' => 'required',
                ],
                [
                    'password.required' => 'The password field is required.',
                    'confirm_password.min' => 'The confirm password must be at least :min characters.',
                ]
            );
            if ($request->password != $request->confirm_password) {
                return response()->json([
                    'message' => "Password and Confirm password is incorrect. Please review!",
                    'status'=>"error"
                ]);
            }
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['status'] = 'Active';
            $data['password']   = Hash::make($request->password);
            User::create($data);
            return response()->json([
                'message' => "User created successfully.",
                'status'=>"success"
            ]);
            // Toastr::success('User created successfully.','Success');
            // return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = User::where('id',$request->id)->first();
        DB::commit();
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
    public function update(Request $request)
    {
        try{
            $data = User::find($request->id);
            $data['user']                       = $request->user;
            $data['name']                       = $request->name;
            $data['email']                      = $request->email;
            $data['signature']                 = $request->signature;
            $data['autoassign']                 = $request->autoassign;
            $data["afterreply"]                 = $request->afterreply;
            $data["autostart"]                  = $request->autostart;
            $data["notify_customer_new"]        = $request->notify_customer_new;
            $data["notify_customer_reply"]      = $request->notify_customer_reply;
            $data["show_suggested"]             = $request->show_suggested;
            $data["autoreload"]                 = $request->autoreload;
            $data["secmin"]                     = $request->secmin;
            $data["notify_new_unassigned"]      = $request->notify_new_unassigned;
            $data["notify_new_my"]              = $request->notify_new_my;
            $data["notify_reply_unassigned"]    = $request->notify_reply_unassigned;
            $data["notify_reply_my"]            = $request->notify_reply_my;
            $data["notify_overdue_unassigned"]  = $request->notify_overdue_unassigned;
            $data["notify_overdue_my"]          = $request->notify_overdue_my;
            $data["notify_assigned"]            = $request->notify_assigned;
            $data["notify_note"]                = $request->notify_note;
            $data["notify_pm"]                  = $request->notify_pm;
            $data['status']                     = 'Active';
            $data['updated_by']                 = Auth::user()->id;
            $data->save();
            return response()->json([
                'message' => "Update created successfully.",
                'status'=>"success"
            ]);
            // Toastr::success('User updated successfully.','Success');
            // return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User updated fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            User::destroy($request->id);
            Toastr::success('User deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User delete fail.','Error');
            return redirect()->back();
        }
    }
}
