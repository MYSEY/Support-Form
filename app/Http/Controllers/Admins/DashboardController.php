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
        if (Auth::user()->RolePermission=='staff' || Auth::user()->RolePermission=='admin') {
            $data = DB::table('onlines')
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
            )
            ->where('department_id',Auth::user()->department_id)
            ->get();
        }else{
            $data = DB::table('onlines')
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
            )->get();
        }
        
        return view('dashboads.admin',compact('data'));
    }
    public function show(Request $request){
        $dataCustomStatuses = DB::table('custom_statuses')->get();
        $dataPriorities = DB::table('priorities')->get();
        if (Auth::user()->RolePermission=='staff' || Auth::user()->RolePermission=='admin') {
            $dataTickets = DB::table('tickets')->where('department_id',Auth::user()->department_id)->get();
        }else{
            $dataTickets = DB::table('tickets')->get();
           
        }
       
        return response()->json([
            'dataTickets'=>$dataTickets,
            'customStatuses'=>$dataCustomStatuses,
            'priorities'=>$dataPriorities,
        ]);
    }
}
