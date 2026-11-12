<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_hr_can_create_department(): void
    {
        $hr = $this->makeUser(Role::HR);
        $this->actingAs($hr)->post(route('departments.store'), [
            'name' => 'Sales department',
            'code' => 'sales',
            'description' => 'sales department',
        ])->assertRedirectToRoute('departments.index')->assertSessionHas('status');
        $this->assertDatabaseHas('departments', ['code' => 'SALES']);

    }

    public function test_employee_cannot_create_department(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);
        $this->actingAs($employee)->post(route('departments.store'), [
            'name' => 'Sales department',
            'code' => 'sales',
            'description' => 'sales department',
        ])->assertForbidden();
        $this->assertDatabaseMissing('departments', ['name' => 'Sales department']);
    }

    public function test_duplicate_department_is_rejected(): void
    {
        $hr = $this->makeUser(Role::HR);
        Department::create([
            'name' => 'Sales Department',
            'code' => 'SALES',
        ]);

        $this->actingAs($hr)->post(route('departments.store'), [
            'name' => 'Purchase Department',
            'code' => 'sales',
        ])->assertSessionHasErrors('code');

        $this->assertDatabaseCount('departments', 1);
    }

    public function test_unchanged_department_passes_update(): void
    {
        $hr = $this->makeUser(Role::HR);
        $department = Department::create([
            'name' => 'Sales Department',
            'code' => 'SALES',
        ]);

        $this->actingAs($hr)->put(route('departments.update', $department), [
            'name' => $department->name,
            'code' => $department->code,
            'is_active' => 1])->assertRedirectToRoute('departments.index')->assertSessionHasNoErrors();
    }

    public function test_is_active_unchecked_return_saves_false(): void
    {
        $hr = $this->makeUser(Role::HR);
        $department = Department::create([
            'name' => 'Sales Department',
            'code' => 'SALES',
            'is_active' => true,
        ]);

        $this->actingAs($hr)->put(route('departments.update', $department), [
            'name' => $department->name,
            'code' => $department->code,
        ])->assertRedirectToRoute('departments.index')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'is_active' => false,
        ]);
    }
}
