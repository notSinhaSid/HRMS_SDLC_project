<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function store(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $employee = new Employee;
            $employee->forceFill($data)->save();
            $employee->forceFill(['employee_code' => sprintf('EMP%04', $employee->id)])->save();

            return $employee;
        });
    }

    public function update(Employee $employee, array $data): Employee
    {
        // code here for update
        return $employee;
    }
}
