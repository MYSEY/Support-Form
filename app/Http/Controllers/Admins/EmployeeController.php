<?php

namespace App\Http\Controllers\Admins;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
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
}
