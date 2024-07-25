<?php

namespace App\Http\Controllers\Auth;

use App\Models\Online;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username          = $request->username;
        $password       = $request->password; 
        $user = User::where("user",$username)->first();
        if ($user) {
            if($user->status == "Active"){
                if (!Hash::check($password, $user->password)) {
                    return response()->json([
                        'message' => "Wrong username or password",
                        'status'=>"error"
                    ]);
                }else{
                    if (Auth::attempt(['user' => $username, 'password' => $password])) {
                        return response()->json([
                            'message' => "Login successfully",
                            'status'=>"success",
                        ]);
                    }else {
                        return response()->json([
                            'message' => "Wrong username or password",
                            'status'=>"error"
                        ]);
                    }
                }
            }else if ($user->status == null || $user->status == "") {
                return response()->json([
                    'message' => "Login successfully",
                    'status'=>"change_password",
                ]);
            }else{
                return response()->json([
                    'message' => "Your account has been shut down. Please contact support",
                    'status'=>"error"
                ]);
            }
        }else {
            return response()->json([
                'message' => "Wrong username or password",
                'status'=>"error"
            ]);
        }



        // if (Auth::attempt(['email' => $email, 'password' => $password])) {
        //     if (Auth::user()->status == 'Active') {
        //         Toastr::success('Login successfully.', 'Success');
        //         $user = DB::table('users')->where('id',Auth::user()->id)->first();
        //         Online::updateOrCreate([
        //             'user_id' => $user->id,
        //         ],
        //         [
        //             'user_id' => $user->id,
        //             'dt' => Carbon::now(),
        //         ]);
        //         return redirect('admin/dashboad');
        //     } else {
        //         dd(3456789);
        //         Auth::logout();
        //         Toastr::error('Your account is not active. Please contact support.', 'Error');
        //         return redirect('login');
        //     }
        // }else {
        //     dd(22222222222);
        //     Toastr::error('Wrong email or password', 'Error');
        //     return redirect('login');
        // }
    }

    public function changePassword(Request $request)
    {
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
                if (Auth::attempt(['user' => $request->username, 'password' => $request->new_password])) {
                    return response()->json([
                        'message' => "Login successfully",
                        'status'=>"success",
                    ]);
                }
            }
        } catch (\Throwable $exp) {
            return response()->json(['errors' => $exp]);
        }
    }
    
    public function logout()
    {
        Online::where('user_id',Auth::user()->id)->delete();
        Auth::logout();
        Toastr::success('Logout successfully', 'Success');
        return redirect('login');
    }
}
