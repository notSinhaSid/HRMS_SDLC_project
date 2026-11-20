<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_hr_can_create_employee_normally(): void
    {
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

    public function test_employee_codes_are_unique_for_every_employee(): void
    {
        $hr = $this->makeUser(Role::HR);

        $user1 = $this->makeUser(Role::EMPLOYEE);
        $department1 = Department::factory()->create();
        $designation1 = Designation::factory()->create();

        $user2 = $this->makeUser(Role::EMPLOYEE, ['name' => 'Manish', 'email' => 'manish@hrms.com']);
        $department2 = Department::factory()->create();
        $designation2 = Designation::factory()->create();

        $this->actingAs($hr)->post(route('employees.store'), [
            'user_id' => $user1->id,
            'department_id' => $department1->id,
            'designation_id' => $designation1->id,
            'phone' => '9899644582',
            'gender' => 'female',
            'date_of_joining' => '2026-11-21',
        ])->assertSessionHasNoErrors();
        $row1 = Employee::where('user_id', $user1->id)->firstOrFail();
        $this->actingAs($hr)->post(route('employees.store'), [
            'user_id' => $user2->id,
            'department_id' => $department2->id,
            'designation_id' => $designation2->id,
            'phone' => '9654326079',
            'gender' => 'male',
            'date_of_joining' => '2026-11-20',
        ])->assertSessionHasNoErrors();
        $row2 = Employee::where('user_id', $user2->id)->firstOrFail();

        $this->assertSame(sprintf('EMP%04d', $row1->id), $row1->employee_code);
        $this->assertSame(sprintf('EMP%04d', $row2->id), $row2->employee_code);
        $this->assertNotSame($row1->employee_code, $row2->employee_code);
    }
}
