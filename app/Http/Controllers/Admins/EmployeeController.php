<?php

namespace App\Http\Controllers\Admins;

use App\Exports\StaffResign;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StaffResign as ModelsStaffResign;
use App\Repositories\Admin\EmployeeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $employeeRepo;
    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo = $employeeRepo;
        RolePermission($this, 'Employee');
    }
    public function index()
    {
        $data = Employee::whereIn('emp_status',['Probation','1','10','2'])
        ->leftJoin('positions','users.position_id','=','positions.id')
        ->leftJoin('departments','users.department_id','=','departments.id')
        ->leftJoin('branchs','users.branch_id','=','branchs.id')
        ->leftJoin('options','users.gender','=','options.id')
        ->select(
            'users.id',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.gender',
            'users.position_id',
            'users.department_id',
            'users.date_of_commencement',
            'positions.name_khmer',
            'positions.name_english',
            'departments.name_english as depart_name',
            'branchs.abbreviations',
            'options.name_khmer as gender'
        )->get();
        return view('employee.index',compact('data'));
    }

    public function staffResigns(Request $request) {
        $staffResign = $this->employeeRepo->staff_resign($request);
        $data = $staffResign->get();
        return view('employee.staff_resign',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportStaffResign(Request $request) {
        $staffResignQuery = $this->employeeRepo->staff_resign($request);
        $data = $staffResignQuery->get();
        if ($data->count() > 0) {
            $insertData = [];
            $now = Carbon::now();

            foreach ($data as $employee) {
                // ឆែកមើលថា តើមានក្នុង staff_resign រួចហើយឬនៅ ដើម្បីការពារ error
                $exists = ModelsStaffResign::where('employee_id', $employee->id)->exists();
                if (!$exists) {
                    $insertData[] = [
                        'employee_id' => $employee->id,
                        'is_check'    => 1,
                        'export_date' => $now->format('Y-m-d H:i:s'),
                    ];
                }
            }

            if (!empty($insertData)) {
                ModelsStaffResign::insert($insertData);
            }
        }

        $filename = 'staff_resign_' . Carbon::now()->format('Ymd') . '.xlsx';
        return Excel::download(new StaffResign($data), $filename);
    }

    public function reportStaffResign(Request $request)
    {
        if (!auth()->user()?->can('Staff Resign Report View')) {
            return view('upgrade.feature_not_available');
        }
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        if ($request->ajax()) {
            $query = Employee::whereIn('users.emp_status', ['3','4','5','6','7','8','9'])
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->leftJoin('options', 'users.gender', '=', 'options.id')
                ->leftJoin('staff_resign', 'users.id', '=', 'staff_resign.employee_id')
                ->whereNotNull('users.resign_date')
                ->select(
                    'users.id',
                    'users.number_employee',
                    'users.employee_name_kh',
                    'users.employee_name_en',
                    'users.resign_date',
                    'users.updated_at',
                    'positions.name_khmer',
                    'positions.name_english',
                    'departments.name_english as depart_name',
                    'branchs.abbreviations',
                    'options.name_khmer as gender',
                    'staff_resign.export_date'
                );
            if ($from_date && $to_date) {
                $query->whereBetween('users.resign_date',  [$from_date, $to_date]);
            }

            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('users.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh','like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('users.resign_date', 'like', "%{$searchValue}%")
                    ->orWhere('users.updated_at', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.abbreviations', 'like', "%{$searchValue}%")
                    ->orWhere('staff_resign.export_date', 'like', "%{$searchValue}%");
                });
            }
            
            // Fetch paginated data
            $recordsTotal = Employee::count();
            $recordsFiltered = $query->count();
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->orderBy('users.id', 'DESC')->offset($start)->limit($limit)->get();
            
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        return view('reports.staff_resign');
    }
    public function exportReportStaffResign(Request $request) {
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        $query = Employee::whereIn('users.emp_status', ['3','4','5','6','7','8','9'])
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('options', 'users.gender', '=', 'options.id')
            ->leftJoin('staff_resign', 'users.id', '=', 'staff_resign.employee_id')
            ->whereNotNull('users.resign_date')
            ->select(
                'users.id',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.resign_date',
                'users.updated_at',
                'positions.name_khmer',
                'positions.name_english',
                'departments.name_english as depart_name',
                'branchs.abbreviations',
                'options.name_khmer as gender',
                'staff_resign.export_date'
            );
            if ($from_date && $to_date) {
                $query->whereBetween('users.resign_date',  [$from_date, $to_date]);
            }
            $data = $query->get();
        $filename = 'report_staff_resign_' . Carbon::now()->format('Ymd') . '.xlsx';

        return Excel::download(new StaffResign($data), $filename);
    }
}
