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
        ->select(
            'onlines.*',
            'users.id',
            'users.name',
            'users.email',
            'users.user',
        )->get();
        return view('dashboads.admin',compact('data'));
    }
    public function show(Request $request){
        $dataTickets = DB::table('tickets')->get();
        return response()->json([
            'dataTickets'=>$dataTickets,
        ]);
    }
}
