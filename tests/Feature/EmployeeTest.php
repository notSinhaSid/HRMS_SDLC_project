<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
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

    private function validPayload(User $user, array $overrides = []): array
    {
        $department = Department::factory()->create();
        $designation = Designation::factory()->create();

        return array_merge([
            'user_id' => $user->id,
            'department_id' => $department->id,
            'designation_id' => $designation->id,
            'phone' => '9517538246',
            'address' => 'Dallas, USA',
            'date_of_birth' => '1997-05-29',
            'date_of_joining' => '2026-11-21',
        ], $overrides);

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

    public function test_user_with_employee_row_cannot_get_second(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user1 = $this->makeUser(Role::EMPLOYEE);
        $department1 = Department::factory()->create();
        $designation1 = Designation::factory()->create();
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
        $response = $this->actingAs($hr)->post(route('employees.store'), [
            'user_id' => $user1->id,
            'department_id' => $department2->id,
            'designation_id' => $designation2->id,
            'phone' => '9899644582',
            'gender' => 'female',
            'date_of_joining' => '2026-11-21',
        ]);
        $response->assertSessionHasErrors('user_id');
        $this->assertSame(1, Employee::where('user_id', $user1->id)->count());

        $row = Employee::where('user_id', $user1->id)->firstOrFail();
        $this->assertSame($department1->id, $row->department_id);
    }

    public function test_inactive_user_is_rejected_from_employee_creation(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE, ['status' => 'inactive']);
        $payload = $this->validPayload($user);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasErrors('user_id');
        $this->assertDatabaseMissing('employees', ['user_id' => $user->id]);
    }

    public function test_hr_cannot_pick_user_with_unassignable_roles(): void
    {
        $hr = $this->makeUser(Role::HR);
        $target = $this->makeUser(Role::HR, ['email' => 'hrInTrainee@hrms.com']);
        $payload = $this->validPayload($target);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasErrors('user_id');
        $this->assertDatabaseMissing('employees', ['user_id' => $target->id]);
    }

    public function test_manager_and_employee_cannot_store_employee(): void
    {
        $emp = $this->makeUser(Role::EMPLOYEE, ['email' => 'emp.hrms@new.com']);
        $manager = $this->makeUser(Role::MANAGER, ['email' => 'justanother@hrms.com']);

        $target = $this->makeUser(Role::EMPLOYEE, ['email' => 'target@hrms.com']);
        $payload = $this->validPayload($target);

        $this->actingAs($emp)->post(route('employees.store', $payload))->assertForbidden();
        $this->assertDatabaseMissing('employees', ['user_id' => $target->id]);
        $this->actingAs($manager)->post(route('employees.store', $payload))->assertForbidden();
        $this->assertDatabaseMissing('employees', ['user_id' => $target->id]);
    }

    public function test_employee_and_manager_cannot_access_employee_create_and_edit_pages(): void
    {
        $emp = $this->makeUser(Role::EMPLOYEE, ['email' => 'emp.hrms@new.com']);
        $manager = $this->makeUser(Role::MANAGER, ['email' => 'justanother@hrms.com']);
        $target = $this->makeUser(Role::EMPLOYEE, ['email' => 'target@hrms.com']);
        $payload = $this->validPayload($target);

        $this->actingAs($this->makeUser(Role::HR))->post(route('employees.store', $payload))->assertSessionHasNoErrors();

        $employee = Employee::where('user_id', $target->id)->firstOrFail();

        $this->actingAs($emp)->get(route('employees.create'))->assertForbidden();
        $this->actingAs($manager)->get(route('employees.create'))->assertForbidden();

        $this->actingAs($emp)->get(route('employees.edit', $employee))->assertForbidden();
        $this->actingAs($manager)->get(route('employees.edit', $employee))->assertForbidden();
    }

    public function test_employee_update_cannot_be_performed_by_employee_and_manager(): void
    {
        $hr = $this->makeUser(Role::HR);
        $emp = $this->makeUser(Role::EMPLOYEE, ['email' => 'emp.hrms@new.com']);
        $manager = $this->makeUser(Role::MANAGER, ['email' => 'justanother@hrms.com']);
        $target = $this->makeUser(Role::EMPLOYEE, ['email' => 'target@hrms.com']);
        $payload = $this->validPayload($target);

        $this->actingAs($hr)->post(route('employees.store', $payload))->assertSessionHasNoErrors();

        $employee = Employee::where('user_id', $target->id)->firstOrFail();
        $originalDOB = $employee->date_of_birth;

        $this->actingAs($emp)->put(route('employees.update', $employee), [
            'gender' => 'others',
            'date_of_joining' => '2026-11-27',
        ])->assertForbidden();
        $this->actingAs($manager)->put(route('employees.update', $employee), [
            'date_of_birth' => '1995-12-01',
            'date_of_joining' => '2026-11-30',
        ])->assertForbidden();
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'gender' => null,
            'date_of_birth' => $originalDOB,
        ]);
        $fresh = Employee::findOrFail($employee->id);
        $this->assertNull($fresh->gender);
        $this->assertTrue($originalDOB->equalTo($fresh->date_of_birth));
    }

    public function test_stray_user_id_and_employee_code_are_ignored_from_the_payload(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $other = $this->makeUser(Role::EMPLOYEE, ['email' => 'other@hrms.com']);
        $payload = $this->validPayload($user);

        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasNoErrors();

        $row = Employee::where('user_id', $user->id)->firstOrFail();
        $originalCode = $row->employee_code;

        $this->actingAs($hr)->put(route('employees.update', $row), [
            'user_id' => $other->id,
            'employee_code' => 'EMP9999',
            'date_of_joining' => '2026-11-24',
            'gender' => 'others',
        ])->assertSessionHasNoErrors();

        $rowNew = Employee::findOrFail($row->id);

        $this->assertSame($user->id, $rowNew->user_id);
        $this->assertSame($originalCode, $rowNew->employee_code);
    }

    public function test_editable_fields_contain_new_values_after_update(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $payload = $this->validPayload($user);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasNoErrors();
        $row = Employee::where('user_id', $user->id)->firstOrFail();
        $this->actingAs($hr)->put(route('employees.update', $row), [
            'phone' => '8800440865',
            'address' => 'Lake town, Philly',
            'gender' => 'female',
            'date_of_joining' => '2026-11-24',
        ])->assertSessionHasNoErrors();
        $newRow = Employee::findOrFail($row->id);
        $this->assertSame('8800440865', $newRow->phone);
        $this->assertSame('female', $newRow->gender);
        $this->assertSame('Lake town, Philly', $newRow->address);
    }

    public function test_date_of_joining_is_required_on_update(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $payload = $this->validPayload($user);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasNoErrors();
        $row = Employee::where('user_id', $user->id)->firstOrFail();
        unset($payload['date_of_joining']);
        $this->actingAs($hr)->put(route('employees.update', $row), $payload)
            ->assertSessionHasErrors('date_of_joining');

        $this->assertSame(
            '2026-11-21',
            Employee::findOrFail($row->id)->date_of_joining->toDateString()
        );
    }

    public function test_date_of_joining_is_required_on_store(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $payload = $this->validPayload($user);
        unset($payload['date_of_joining']);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasErrors('date_of_joining');
        $this->assertDatabaseMissing('employees', ['user_id' => $user->id]);
    }
}
