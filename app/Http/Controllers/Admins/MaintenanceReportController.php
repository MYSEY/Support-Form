<?php

namespace App\Http\Controllers\Admins;

use App\Models\Asset;
use App\Models\Branch;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\MaintenanceExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MaintenanceReportController extends Controller
{
    public function report(Request $request){
        $maintenance_date = null;
        if ($request->maintenance_date) {
            $maintenance_date = Carbon::createFromDate($request->maintenance_date)->format('Y-m-d');
        }
        if (request()->ajax()) {
            // Define the base query
            $query = DB::table('maintenances')
            ->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
            ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
            ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id')
            ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
            ->select(
                'maintenances.*', 
                'assets.serial', 
                'assets.device_name', 
                'categories.name as category_name', 
                'users.number_employee', 
                'users.employee_name_kh', 
                'users.employee_name_en',
                'positions.name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'rooms.name as location',
            )->where('maintenances.deleted_at',null)
            ->when($request->serial, function ($query, $serial) {
                $query->where('assets.serial', $serial);
            })->when($request->office, function ($query, $office) {
                $query->where('branchs.id', $office);
            })->when($request->staff_name, function ($query, $staff_name) {
                return $query->where('users.employee_name_en', 'LIKE', "%{$staff_name}%");
            })->when($maintenance_date, function ($query, $maintenance_date) {
                $query->where('maintenances.maintenance_date', $maintenance_date);
            });
            
            // Fetch paginated data
            $recordsTotal = Maintenance::where('id', Auth::user()->id)->count();
            $recordsFiltered = $query->count();
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->orderBy('maintenances.id', 'DESC')->offset($start)->limit($limit)->get();
            
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $serial = Asset::whereNotNull('serial')->get();
        $office = Branch::all();
        return view('reports.maintenance.report',compact('serial','office'));
    }

    public function maintenanceExport(Request $request){
        return Excel::download(new MaintenanceExport($request), 'Maintanance Report.xlsx');
    }
}