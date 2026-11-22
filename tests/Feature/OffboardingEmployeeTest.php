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

class OffboardingEmployeeTest extends TestCase
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

    public function test_hr_can_offboard_employee(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $payload = $this->validPayload($user);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasNoErrors();
        $row = Employee::where('user_id', $user->id)->firstOrFail();
        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [
            'date_of_leaving' => '2026-11-27',
        ])->assertRedirectToRoute('employees.index');

        $row = Employee::findOrFail($row->id);
        $user = User::findOrFail($user->id);
        // since offboard means not perma or soft delete, we dont use missing assert but check if the date of leaving and status in user are same as we intended
        $this->assertSame('2026-11-27', $row->date_of_leaving?->format('Y-m-d'));
        $this->assertSame('inactive', $user->status);
    }

    public function test_user_cannot_offboard_employee_with_same_or_higher_role(): void
    {
        $hr = $this->makeUser(Role::HR);
        $admin = $this->makeUser(Role::SUPER_ADMIN);
        $row = Employee::factory()->create(['user_id' => $admin->id]);

        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [
            'date_of_leaving' => '2026-11-29',
        ])->assertForbidden();
        $row = Employee::findOrFail($row->id);
        $admin = User::findOrFail($admin->id);
        $this->assertSame(null, $row->date_of_leaving);
        $this->assertSame('active', $admin->status);
    }

    public function test_self_offboarding_is_prohibited(): void
    {
        $hr = $this->makeUser(Role::HR);
        $row = Employee::factory()->create(['user_id' => $hr->id]);

        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [
            'date_of_leaving' => '2026-11-30',
        ])->assertForbidden();
        $row = Employee::findOrFail($row->id);
        $user = User::findOrFail($hr->id);
        $this->assertSame(null, $row->date_of_leaving);
        $this->assertSame('active', $user->status);
    }

    public function test_employee_and_manager_cannot_perform_offboarding(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);
        $manager = $this->makeUser(Role::MANAGER);
        $row1 = Employee::factory()->create(['user_id' => $employee->id]);
        $row2 = Employee::factory()->create(['user_id' => $manager->id]);

        $this->actingAs($employee)->post(route('employees.offboard', $row1->id), [
            'date_of_leaving' => '2026-11-30',
        ])->assertForbidden();

        $this->actingAs($manager)->post(route('employees.offboard', $row2->id), [
            'date_of_leaving' => '2026-11-30',
        ])->assertForbidden();

        $row1 = Employee::findOrFail($row1->id);
        $employee = User::findOrFail($employee->id);
        $this->assertSame(null, $row1->date_of_leaving);
        $this->assertSame('active', $employee->status);

        $row2 = Employee::findOrFail($row2->id);
        $manager = User::findOrFail($manager->id);
        $this->assertSame(null, $row2->date_of_leaving);
        $this->assertSame('active', $manager->status);
    }

    public function test_already_offboarded_employee_cannot_be_offboarded_again(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $payload = $this->validPayload($user);
        $this->actingAs($hr)->post(route('employees.store'), $payload)->assertSessionHasNoErrors();

        $row = Employee::where('user_id', $user->id)->firstOrFail();

        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [
            'date_of_leaving' => '2026-11-27',
        ])->assertSessionHasNoErrors();

        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [
            'date_of_leaving' => '2026-11-29',
        ])->assertSessionHasErrors('message');

        $row = Employee::findOrFail($row->id);
        $user = User::findOrFail($user->id);
        $this->assertSame('2026-11-27', $row->date_of_leaving->format('Y-m-d'));
        $this->assertSame('inactive', $user->status);
    }

    public function test_date_of_leaving_come_before_date_of_joining(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id, 'date_of_joining' => '2026-11-05']);
        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [
            'date_of_leaving' => '2026-11-01',
        ])->assertSessionHasErrors('date_of_leaving');
        $row = Employee::findOrFail($row->id);
        $this->assertSame(null, $row->date_of_leaving);
        $user = User::findOrFail($user->id);
        $this->assertSame('active', $user->status);
    }

    public function test_date_of_leaving_is_required_for_offboarding(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id]);

        $this->actingAs($hr)->post(route('employees.offboard', $row->id), [])->assertSessionHasErrors('date_of_leaving');
        $row = Employee::findOrFail($row->id);
        $this->assertSame(null, $row->date_of_leaving);
        $user = User::findOrFail($user->id);
        $this->assertSame('active', $user->status);
    }
}
