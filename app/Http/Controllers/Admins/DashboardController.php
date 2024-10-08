<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
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
        $query = DB::table('onlines')
        ->leftJoin('users','onlines.user_id','=','users.id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->select(
            'onlines.*',
            'users.id',
            'users.name',
            'users.email',
            'users.user',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        );
        // Apply additional filtering for role
        if (Auth::user()->RolePermission=='staff') {
            $query->where('department_id',Auth::user()->department_id);
        }
        $data = $query->orderBy('onlines.id','DESC')->get();
        return view('dashboads.admin',compact('data'));
    }
    public function show(Request $request){
        $dataCustomStatuses = DB::table('custom_statuses')->get();
        $dataPriorities = DB::table('priorities')->get();
        $query = DB::table('tickets')->where('deleted_at',null);

        // Apply additional filtering for role
        if (Auth::user()->RolePermission=='staff') {
            $query->where('department_id',Auth::user()->department_id)->where('created_by',Auth::user()->id);
        }
        $dataTickets = $query->orderBy('id','DESC')->get();
        return response()->json([
            'dataTickets'=>$dataTickets,
            'customStatuses'=>$dataCustomStatuses,
            'priorities'=>$dataPriorities,
        ]);
    }
}
