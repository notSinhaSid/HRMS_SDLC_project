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

    public function checkInMoment():Carbon {
        return Carbon::parse('2026-11-27 20:30:00', 'UTC');
    }

    public function test_employee_can_check_in_successfully(): void {
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id]);
        $this->travelTo($this->checkInMoment());
        $this->actingAs($user)->post(route('attendance.checkin'))->assertRedirectToRoute('dashboard')->assertSessionHas('status');

        $this->assertSame(1, $row->attendances()->count());
        $attendance = $row->attendances()->firstOrFail();
        $this->assertSame('2026-11-28', $attendance->work_date->toDateString());
        $this->assertSame('2026-11-27 20:30:00', $attendance->check_in_time->toDateTimeString());
    }

    public function test_second_check_in_a_day_is_prohibitted() : void {
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id]);
        $this->travelTo($this->checkInMoment());

        $this->actingAs($user)->post(route('attendance.checkin'))->assertRedirectToRoute('dashboard')->assertSessionHas('status');
        $this->assertSame(1, $row->attendances()->count());

        $this->actingAs($user)->post(route('attendance.checkin'))->assertSessionHasErrors(['message' => __('messages.attendance.already_checked_in')]);
        $this->assertSame(1, $row->attendances()->count());
        $attendance = $row->attendances()->firstOrFail();
        $this->assertSame('2026-11-28', $attendance->work_date->toDateString());
        $this->assertSame('2026-11-27 20:30:00', $attendance->check_in_time->toDateTimeString());
    }

}
