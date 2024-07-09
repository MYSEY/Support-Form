<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
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
        return view('dashboads.admin',compact('data'));
    }
    public function show(Request $request){
        $dataTickets = DB::table('tickets')->get();
        $dataCustomStatuses = DB::table('custom_statuses')->get();
        $dataPriorities = DB::table('priorities')->get();
        return response()->json([
            'dataTickets'=>$dataTickets,
            'customStatuses'=>$dataCustomStatuses,
            'priorities'=>$dataPriorities,
        ]);
    }
}
