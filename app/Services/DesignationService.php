<?php

namespace App\Services;

use App\Models\Designation;

class DesignationService
{
    public function store(array $data): Designation
    {
        $designation = Designation::create($data);

        return $designation;
    }

    public function update(Designation $designation, array $data): Designation
    {
        $designation->update($data);

        return $designation;
    }
}
