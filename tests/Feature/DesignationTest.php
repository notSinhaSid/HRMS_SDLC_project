<?php

namespace Tests\Feature;

use App\Models\Designation;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class DesignationTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_hr_can_create_designation(): void
    {
        $hr = $this->makeUser(Role::HR);
        $this->actingAs($hr)->post(route('designations.store', [
            'name' => 'Python Developer',
        ]))->assertRedirectToRoute('designations.index')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('designations', ['name' => 'Python developer']);
    }

    public function test_designation_creation_forbidden_for_other_roles(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);
        $manager = $this->makeUser(Role::MANAGER);
        $this->actingAs($employee)->post(route('designations.store', [
            'name' => 'Python Developer',
        ]))->assertForbidden();
        $this->actingAs($manager)->post(route('designations.store', [
            'name' => 'Python Developer',
        ]))->assertForbidden();
    }

    public function test_designation_name_is_normalized(): void
    {
        $hr = $this->makeUser(Role::HR);
        $this->actingAs($hr)->post(route('designations.store', [
            'name' => '   Python    Developer   ',
        ]))->assertSessionHasNoErrors();

        $this->assertDatabaseHas('designations', ['name' => 'Python developer']);
    }

    public function test_duplicate_designation_are_blocked(): void
    {
        $hr = $this->makeUser(Role::HR);
        Designation::create([
            'name' => 'Project lead',
        ]);

        $this->actingAs($hr)->post(route('designations.store'), [
            'name' => '  Project lead',
        ])->assertSessionHasErrors('name');
        $this->assertDatabaseCount('designations', 1);
    }

    public function test_designation_update_forbides_duplicate_entry(): void
    {
        $hr = $this->makeUser(Role::HR);
        Designation::create([
            'name' => 'Project lead',
        ]);
        $designation2 = Designation::create([
            'name' => 'Senior dev',
        ]);

        $this->actingAs($hr)->patch(route('designations.update', $designation2), [
            'name' => '  Project lead',
        ])->assertSessionHasErrors('name');
        $this->assertDatabaseCount('designations', 2);
    }
}
