<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase, CreateUsers;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_employee_can_check_in_successfully(): void {
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id]);
        $this->travelTo(Carbon::parse('2026-11-27 20:30:00', 'UTC'));
        $this->actingAs($user)->post(route('attendance.checkin'))->assertRedirectToRoute('dashboard')->assertSessionHas('status');

        $this->assertSame(1, $row->attendances()->count());
        $attendance = $row->attendances()->firstOrFail();
        $this->assertSame('2026-11-28', $attendance->work_date->toDateString());
        $this->assertSame('2026-11-27 20:30:00', $attendance->check_in_time->toDateTimeString());
    }

}
