<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
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
        /* $emp = new Employee();
        $emp->department->name; */
        $employees = Employee::with(['users','departments','designations'])->get();
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
