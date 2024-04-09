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
    public function index()
    {
        $data = User::get();
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
    public function update(Request $request, string $id)
    {
        //
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
