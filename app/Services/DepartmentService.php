<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    public function store(array $data): Department
    {
        $department = Department::create($data);

        return $department;
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);

        return $department;
    }
}
