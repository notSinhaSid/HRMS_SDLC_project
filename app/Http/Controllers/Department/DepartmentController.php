<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $departmentService) {}

    public function index()
    {
        $departments = Department::all();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = $this->departmentService->store($request->validated());

        return redirect()->route('departments.index')->with(['status' => __('messages.departments.create_success', ['name' => $department->name])]);
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
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Department $department, UpdateDepartmentRequest $request)
    {
        $department = $this->departmentService->update($department, $request->validated());

        return redirect()->route('departments.index')->with(['status' => __('messages.departments.update_success', ['name' => $department->name])]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
