<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase, CreateUsers;

    #[Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_hr_can_create_employee_normally(): void {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $department = Department::factory()->create();
        $designation = Designation::factory()->create();
        $this->actingAs($hr)->post(route('employees.store'), [
            'user_id' => $user->id,
            'department_id' => $department->id,
            'designation_id' => $designation->id,
            'phone' => '9899644582',
            'gender' => 'female',
            'date_of_joining' => '2026-11-21',
        ])->assertSessionHasNoErrors();
        $row = Employee::where('user_id', $user->id)->firstOrFail();
        $this->assertSame(sprintf('EMP%04d', $row->id), $row->employee_code);
    }
}
