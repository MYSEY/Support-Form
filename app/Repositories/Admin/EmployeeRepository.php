<?php

namespace App\Repositories\Admin;

use App\Models\Employee;
use Carbon\Carbon;
use App\Models\GenerateIdEmployee;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];
    protected $department_ids = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Employee::class;
    }

    public function staff_resign($request){
        $today = Carbon::today()->format('Y-m-d');
        $sevenDaysAgo = Carbon::today()->subDays(7)->format('Y-m-d');
        $data = Employee::whereIn('emp_status', ['3','4','5','6','7','8','9'])
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('options', 'users.gender', '=', 'options.id')
            ->leftJoin('staff_resign', 'users.id', '=', 'staff_resign.employee_id')
            ->select(
                'users.id',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.gender',
                'users.position_id',
                'users.department_id',
                'users.date_of_commencement',
                'users.resign_date',
                'users.updated_at',
                'positions.name_khmer',
                'positions.name_english',
                'departments.name_english as depart_name',
                'branchs.abbreviations',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'options.name_khmer as gender',
                'staff_resign.is_check',
                'staff_resign.export_date'
            )
            ->whereNotNull('users.resign_date')
            ->whereBetween('users.resign_date', [$sevenDaysAgo, $today])
            ->whereNull('staff_resign.id')
            ->orderBy('users.resign_date', 'DESC');
        return $data;
    }
}