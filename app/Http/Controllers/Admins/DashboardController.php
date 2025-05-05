<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Branch;
use App\Models\Online;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        RolePermission($this, 'Dashboad');
    }
    public function index(){
        $query = Online::with("userOnline")
        ->leftJoin('users','onlines.user_id','=','users.id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->select(
            'onlines.*',
            'users.id',
            'users.name',
            'users.email',
            'users.profile',
            'users.user',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'roles.name as role_name',
        );
        
        $today = Carbon::today()->toDateString();

        $data = $query->whereDate('onlines.updated_at', $today)->orderBy('onlines.id','DESC')->get();
        $branch = Branch::all();
        return view('dashboads.admin',compact('data','branch'));
    }
    public function show(Request $request){
        $dataCustomStatuses = DB::table('custom_statuses')->get();
        $dataPriorities = DB::table('priorities')->get();
        $users = User::select('id')->get();
        $query = DB::table('tickets')
        ->select(
            'tickets.id',
            'tickets.trackid',
            'tickets.name',
            'tickets.branch_id',
            'tickets.priority',
            'tickets.dt',
            'tickets.status',
            'tickets.owner',
            'tickets.deleted_at'
        )->whereNull('tickets.deleted_at');

        // Apply additional filtering for role
        if (Auth::user()->RolePermission=='staff') {
            $query->where("tickets.created_by", Auth::user()->id);
        }else if(Auth::user()->RolePermission=='admin_support'){
            $query->where('tickets.department_id', Auth::user()->department_id)
            ->orWhere("tickets.created_by", Auth::user()->id)
            ->orWhere("tickets.owner", Auth::user()->id);
        }else if(Auth::user()->RolePermission=='admin'){
            $query->where('tickets.department_id', Auth::user()->department_id)
            ->orWhere('tickets.department_id_from', Auth::user()->department_id);
        }else if(Auth::user()->RolePermission=="admin_branch"){
            $query->where('tickets.branch_id', Auth::user()->branch_id);
        }
        $dataTickets = $query->orderBy('id','DESC')->get();
        return response()->json([
            'dataTickets'=>$dataTickets,
            'customStatuses'=>$dataCustomStatuses,
            'priorities'=>$dataPriorities,
            'users'=>$users,
        ]);
    }
}
