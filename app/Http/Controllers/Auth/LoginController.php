<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

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
        $email          = $request->email;
        $password       = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            if (Auth::user()->status == 'Active') {
                Toastr::success('Login successfully.', 'Success');
                return redirect('admin/dashboad');
            } else {
                Auth::logout();
                Toastr::error('Your account is not active. Please contact support.', 'Error');
                return redirect('login');
            }
        }else {
            Toastr::error('Wrong Email Or Password', 'Error');
            return redirect('login');
        }
    }
    public function logout()
    {
        Auth::logout();
        Toastr::success('Logout successfully', 'Success');
        return redirect('login');
    }
}
