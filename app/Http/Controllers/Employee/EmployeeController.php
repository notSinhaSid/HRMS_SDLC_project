<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService) {}

    public function index()
    {
        $employees = Employee::with(['user', 'department', 'designation'])->orderBy('employee_code')->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $availableUsers = User::availableForEmployee($request->user())->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();

        return view('employees.create', compact(['availableUsers', 'departments', 'designations']))->with('employee', null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $employee = $this->employeeService->store($request->validated());
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['message' => __('messages.employees.create_failed')])
                ->onlyInput(['user_id', 'department_id', 'designation_id', 'phone', 'address', 'gender', 'date_of_birth', 'date_of_joining']);
        }

        return redirect()->route('employees.index')->with(['status' => __('messages.employees.create_success', ['name' => $employee->user->name])]);

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
    public function edit(Employee $employee)
    {
        $departments = Department::where(function ($q) use ($employee) {
            $q->where('is_active', true)->orWhere('id', $employee->department_id);
        })->orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();

        return view('employees.edit', compact(['employee', 'departments', 'designations']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Employee $employee, UpdateEmployeeRequest $request)
    {
        try {
            $employee = $this->employeeService->update($employee, $request->validated());
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['message' => __('messages.employees.update_failed')])
                ->withInput($request->only(['department_id', 'designation_id', 'phone', 'address', 'gender', 'date_of_birth', 'date_of_joining', 'date_of_leaving']));
        }

        return redirect()->route('employees.index')->with(['status' => __('messages.employees.update_success', ['name' => $employee->user->name])]);
    }
    
}
