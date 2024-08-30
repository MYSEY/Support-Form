<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Online;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        RolePermission($this, 'User');
    }

    public function index()
    {
        if (Auth::user()->RolePermission=='staff' || Auth::user()->RolePermission=='admin') {
            $data = DB::table('users')
            ->where("users.deleted_at",null)
            ->leftJoin('branchs','branchs.id','=','users.branch_id')
            ->leftJoin('departments','departments.id','=','users.department_id')
            ->leftJoin('roles','roles.id','=','users.role_id')
            ->select(
                'users.*',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'departments.name_english',
                'roles.name as role_name',
            )
            ->where('department_id',Auth::user()->department_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->get();
        } else {
            $data = DB::table('users')
            ->where("users.deleted_at",null)
            ->leftJoin('branchs','branchs.id','=','users.branch_id')
            ->leftJoin('departments','departments.id','=','users.department_id')
            ->leftJoin('roles','roles.id','=','users.role_id')
            ->select(
                'users.*',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'departments.name_english',
                'roles.name as role_name',
            )->get();
        }
        return view('users.index', compact('data'));
    }
    public function formResetPassword(){
        $users = DB::table('users')->get();
        return view('auth.forgot_password', compact('users'));
    }

    public function resetPassword(Request $request){
        try {
            $request->validate(
                [
                    'username' => 'required',
                    'confirm_password' => 'required',
                    'new_password' => 'required|min:8',
                ],
                [
                    'new_password.required' => 'The new password field is required.',
                    'new_password.min' => 'The new password must be at least :min characters.',
                ]
            );
            if ($request->confirm_password != $request->new_password) {
                return response()->json([
                    'message' => "New password is invalid with password confirmation!",
                    'status'=>"error"
                ]);
            }else{
                $user = User::where("user",$request->username)->first();
                $user->password = Hash::make($request->new_password);
                $user->status = "Active";
                $user->save();
                return response()->json([
                    'message' => "Reset password successfully",
                    'status'=>"success",
                ]);
            }
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rolePermissions = Role::orderBy('id', 'asc')->get();
        $department = DB::table('departments')->get();
        $branch = DB::table('branchs')->get();
        return view('users.form-create', compact('rolePermissions','department','branch'));
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
            $user = User::create($data);
            $user->assignRole($request->role_id);

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
        $rolePermissions = Role::orderBy('id', 'asc')->get();
        $department = DB::table('departments')->get();
        $branch = DB::table('branchs')->get();
        $data = User::where('id',$request->id)->first();
        DB::commit();
        return response()->json([
            'data'=>$data,
            'role'=>$rolePermissions,
            'department'=>$department,
            'branch'=>$branch,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('users.form-edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            $data = $request->all();
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
            $data["role_id"]                    = $request->role_id;
            $data["department_id"]              = $request->department_id;
            $data["branch_id"]                  = $request->branch_id;
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
            $user = User::find($request->id);
            if ($user) {
                $user->update($data);
                // Find the role by ID and get its name
                $role = Role::find($request->role_id);
                if ($role) {
                    $user->syncRoles($role->name); // Use the role name
                } else {
                    return response()->json(['error' => 'Role not found'], 404);
                }
                return response()->json(['success' => 'User updated successfully']);
            }
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

    public function duplicateUser(Request $request){
        try {
            $duplicate= User::where("user",$request->username)->first();
            DB::commit();
            if ($duplicate) {
                return ['message' => 'User name already exists', "data"=>1];
            }else{
                return ['message' => 'User name does not exist', "data"=>0];
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
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
    public function userOnlineDelet(Request $request){
        try{
            if (Auth::user()->id != $request->user_id) {
                Online::where('user_id',$request->user_id)->delete();
            }
            return response()->json([
                'message' => "Delete user online successfully.",
                'status'=>"success"
            ]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete user online fail.','Error');
            return redirect()->back();
        }
    }
}
