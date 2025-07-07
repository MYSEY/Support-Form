<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Asset;
use App\Models\Branch;
use App\Models\Online;
use App\Models\Department;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\MaintenanceStatus;
use App\Models\MaintenanceMission;
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
        $results = [];
        $branches = Branch::select("id", "branch_name_kh", "branch_name_en", "abbreviations")->where('abbreviations','!=','HQ')->get();
        $missions = MaintenanceMission::all();
        foreach ($branches as $branch) {
            $totalAsset = Asset::where('office', $branch->id)->count();
            $branchMissions = [];
            $allMissionMatch = true;

            foreach ($missions as $mission) {
                // Count unique asset_id under maintenance
                $maintenanceCount = Maintenance::where('office', $branch->id)->where('maintenance_mission_id', $mission->id)->distinct('asset_id')->count('asset_id');
                $status = 0;
                if ($totalAsset == 0 || $maintenanceCount == 0) {
                    $status = 0; // No data
                } elseif ($maintenanceCount == $totalAsset) {
                    // Exact match, so status = mission ID (1-4)
                    $status = $mission->id;
                } elseif ($maintenanceCount < $totalAsset) {
                    $status = 0; // Partial
                } elseif ($maintenanceCount > $totalAsset) {
                    $status = 5; // Over-maintained
                }
                
                // Append mission details
                $branchMissions[] = [
                    'mission_id' => $mission->id,
                    'mission_name' => $mission->name ?? 'Unnamed',
                    'total_asset' => $totalAsset,
                    'total_maintenance' => $maintenanceCount,
                    'status' => $status,
                ];
            }

            $results[] = [
                'branch_id' => $branch->id,
                'branch_name_kh' => $branch->branch_name_kh,
                'branch_name_en' => $branch->branch_name_en,
                'abbreviations' => $branch->abbreviations,
                'missions' => $branchMissions
            ];
        }
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

        $mission = MaintenanceMission::all();
        $branch = Branch::select(
            "id",
            "branch_name_kh",
            "branch_name_en",
            "abbreviations"
        )->where('abbreviations','!=','HQ')->get();

        $department = Department::select(
            "id",
            "name_khmer",
            "name_english",
        )->where('type','infra')->get();

        $resultsDepartment = [];
        $departments = Department::select("id", "name_khmer", "name_english")->where('type', 'infra')->get();
        foreach ($departments as $department) {
            $totalAsset = Asset::where('department_id', $department->id)->count();
            $departmentMissions = [];
            foreach ($missions as $mission) {
                $maintenanceCount = Maintenance::where('department_id', $department->id)->where('maintenance_mission_id', $mission->id)->distinct('asset_id')->count('asset_id');
                $totalMaintenances = Maintenance::where('department_id', $department->id)->where('maintenance_mission_id', $mission->id)->count();
                $status = 0;
                if ($totalAsset == 0 || $maintenanceCount <= 1) {
                    $status = 0; // No data or too little
                } elseif ($maintenanceCount == $totalAsset && $totalMaintenances == $totalAsset) {
                    $status = 1; // Fully completed
                } elseif ($maintenanceCount < $totalAsset) {
                    $status = 2; // Partial
                } elseif ($maintenanceCount == $totalAsset && $totalMaintenances > $totalAsset) {
                    $status = 3; // Redundant
                } elseif ($maintenanceCount > $totalAsset) {
                    $status = 4; // Over-maintained
                }

                $departmentMissions[] = [
                    'mission_id' => $mission->id,
                    'mission_name' => $mission->name ?? 'Unnamed',
                    'total_asset' => $totalAsset,
                    'total_maintenance' => $maintenanceCount,
                    'status' => $status,
                ];
            }

            $resultsDepartment[] = [
                'department_id' => $department->id,
                'name_khmer' => $department->name_khmer,
                'name_english' => $department->name_english,
                'missions' => $departmentMissions,
            ];
        }
        return view('dashboads.admin',compact('data','branch','resultsDepartment','departments','results'));
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
        $maintenanceMission = Maintenance::with('maintenanceDetail')->whereNotNull('maintenance_mission_id')->select('id','asset_id','category_id','office','department_id')->get();
        $maintenanceMissionCashByCash = Maintenance::with('maintenanceDetail')->where('maintenance_mission_id',null)->select('id','asset_id','category_id','office','department_id')->get();
        $branch = Branch::select(
            "id",
            "branch_name_kh",
            "branch_name_en",
            "abbreviations"
        )->get();
        $maintenanceStatus = MaintenanceStatus::get();
        return response()->json([
            'dataTickets'=>$dataTickets,
            'customStatuses'=>$dataCustomStatuses,
            'priorities'=>$dataPriorities,
            'maintenanceMission'=>$maintenanceMission,
            'maintenanceMissionCashByCash'=>$maintenanceMissionCashByCash,
            'branch'=>$branch,
            'maintenanceStatus'=>$maintenanceStatus,
            'users'=>$users,
        ]);
    }
}
