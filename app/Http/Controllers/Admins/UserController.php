<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Online;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $data = User::with('role')->with('department')->with("branch")->with("createdBy")->with("updatedBy")
            ->where('department_id',Auth::user()->department_id)
            ->where('branch_id',Auth::user()->branch_id)
            ->get();
            // $data = DB::table('users')
            // ->where("users.deleted_at",null)
            // ->leftJoin('branchs','branchs.id','=','users.branch_id')
            // ->leftJoin('departments','departments.id','=','users.department_id')
            // ->leftJoin('roles','roles.id','=','users.role_id')
            // ->select(
            //     'users.*',
            //     'branchs.branch_name_kh',
            //     'branchs.branch_name_en',
            //     'departments.name_english',
            //     'roles.name as role_name',
            // )
            // ->where('department_id',Auth::user()->department_id)
            // ->where('branch_id',Auth::user()->branch_id)
            // ->get();
        } else {
            $data = User::with('role')->with('department')->with("branch")->with("createdBy")->with("updatedBy")->get();
            // $data = DB::table('users')
            // ->where("users.deleted_at",null)
            // ->leftJoin('branchs','branchs.id','=','users.branch_id')
            // ->leftJoin('departments','departments.id','=','users.department_id')
            // ->leftJoin('roles','roles.id','=','users.role_id')
            // ->select(
            //     'users.*',
            //     'branchs.branch_name_kh',
            //     'branchs.branch_name_en',
            //     'departments.name_english',
            //     'roles.name as role_name',
            // )->get();
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
        return view('users.create', compact('rolePermissions','department','branch'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            if($request->hasFile('profile')) {
                $image = $request->file('profile');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('storage/users/profile'), $imageName);
            }
            
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['profile'] = $imageName;
            $data['status'] = 'Active';
            $data['password']   = Hash::make($request->password);
            $user = User::create($data);
            $roleName = Role::find($request->role_id)->name;
            $user->assignRole($roleName);

            // return response()->json([
            //     'message' => "User created successfully.",
            //     'status'=>"success"
            // ]);
            Toastr::success('User created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('User created fail.','Error');
            return redirect()->back();
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
    public function edit($id)
    {
        $roles = Role::orderBy('id', 'asc')->get();
        $department = DB::table('departments')->select('id','name_khmer','name_english')->get();
        $branch = DB::table('branchs')->select('id','branch_name_kh','branch_name_en')->get();
        $data = User::find($id);
        return view('users.edit',compact('data','roles','department','branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            if($request->hasFile('profile')) {
                $image = $request->file('profile');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('storage/users/profile'), $imageName);
            }else{
                $imageName = $request->old_profile;
            }
            $data = $request->all();
            $data['profile']                    = $imageName;
            $data['user']                       = $request->user;
            $data['name']                       = $request->name;
            $data['email']                      = $request->email;
            $data["role_id"]                    = $request->role_id;
            $data["department_id"]              = $request->department_id;
            $data["branch_id"]                  = $request->branch_id;
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
                    Toastr::error('Role not found.','Error');
                }
            }
            Toastr::success('User updated successfully.','Success');
            return redirect('admin/user');
            // return response()->json([
            //     'message' => "Update created successfully.",
            //     'status'=>"success"
            // ]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User updated fail.','Error');
            return redirect()->back();
        }
    }

    public function updateStatus(Request $request) {
        try{
            $user = User::find($request->id);
            $user['status']            = $request->status;
            $user['updated_by']        = Auth::user()->id;
            $user->save();
            return response()->json([
                'message' => "Update status successfully.",
                'status'=>"success"
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'message' => "User updated fail.",
                'status'=>"Error"
            ]);
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
    public function userProfile($id){
        $data = User::find($id);
        return view('users.profile',compact('data',));
    }
    public function userProfileUpdate(Request $request){
        try{
            if($request->hasFile('profile')) {
                $image = $request->file('profile');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('storage/users/profile'), $imageName);
            }else{
                $imageName = $request->old_profile;
            }
            User::where('id',$request->id)->update([
                'updated_by'=> Auth::user()->id,
                'profile'=> $imageName,
            ]);
            return response()->json([
                'message' => "Update created successfully.",
                'status'=>"success"
            ]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User updated fail.','Error');
            return redirect()->back();
        }
    }
}
