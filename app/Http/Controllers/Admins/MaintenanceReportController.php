<?php

namespace App\Http\Controllers\Admins;

use App\Models\Asset;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\MaintenanceExport;
use App\Models\MaintenanceMission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaintenanceDownloadExport;

class MaintenanceReportController extends Controller
{
    public function report(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d');
        }
        if (request()->ajax()) {
            // Define the base query
            $query = DB::table('maintenances')
            ->leftJoin('maintenance_missions', 'maintenances.maintenance_mission_id', '=', 'maintenance_missions.id')
            ->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
            ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
            ->leftJoin('departments', 'maintenances.department_id', '=', 'departments.id')
            ->leftJoin('db_hr-production.users', 'maintenances.end_user', '=', 'users.id')
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
                'departments.name_english as department_name',
                'rooms.name as location',
                'maintenance_missions.name as maintenance_mission',
            )->where('maintenances.deleted_at',null)
            ->when($request->serial, function ($query, $serial) {
                $query->where('assets.serial', $serial);
            })->when($request->office, function ($query, $office) {
                $query->where('maintenances.office', $office);
            })->when($request->department_id, function ($query, $department_id) {
                $query->where('maintenances.department_id', $department_id);
            })->when($request->staff_name, function ($query, $staff_name) {
                return $query->where('users.employee_name_en', 'LIKE', "%{$staff_name}%");
            })->when($request->maintenance_mission, function ($query, $maintenance_mission) {
                return $query->where('maintenances.maintenance_mission_id',$maintenance_mission);
            });
            // ->groupBy('assets.serial')
            if ($from_date && $to_date) {
                $query->whereBetween('maintenances.maintenance_date',  [$from_date, Carbon::parse($to_date)->endOfDay()]);
            }

            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('assets.serial', 'like', "%{$searchValue}%")
                    ->orWhere('assets.device_name', 'like', "%{$searchValue}%")
                    ->orWhere('maintenances.maintenance_date', 'like', "%{$searchValue}%")
                    ->orWhere('users.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('categories.name', 'like', "%{$searchValue}%")
                    ->orWhere('rooms.name', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%");
                });
            }

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
        $department = Department::all();
        $maintenanceMission = MaintenanceMission::all();
        return view('reports.maintenance.report',compact('serial','office','maintenanceMission','department'));
    }

    public function maintenanceExport(Request $request){
        return Excel::download(new MaintenanceExport($request), 'Maintanance Report.xlsx');
    }
    public function maintenanceDownloadExcel(Request $request){
        return Excel::download(new MaintenanceDownloadExport($request), 'Maintanance Report.xlsx');
    }
    public function maintenanceHistory($id){
        $data = Maintenance::with(['maintenanceDetail.task:id,name,type'])
        ->leftJoin('maintenance_missions', 'maintenances.maintenance_mission_id', '=', 'maintenance_missions.id')
        ->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
        ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('rooms', 'maintenances.location', '=', 'rooms.id')
        ->leftJoin('branchs', 'maintenances.office', '=', 'branchs.id')
        ->leftJoin('db_hr-production.users', 'maintenances.end_user', '=', 'db_hr-production.users.id')
        ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
        ->select(
            'maintenances.*', 
            'assets.serial', 
            'assets.date', 
            'assets.device_name', 
            'categories.name as category_name',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'positions.name_english',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'rooms.name as location',
            'maintenance_missions.name as maintenance_mission',
        )->where('asset_id', $id)->orderBy('id','DESC')->get();
        return view('maintenance.history',compact('data'));
    }
}