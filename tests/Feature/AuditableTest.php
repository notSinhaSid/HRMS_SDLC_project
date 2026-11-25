<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class AuditableTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_creating_a_user_logs_one_created_row_without_password(): void
    {
        $hr = $this->makeUser(Role::HR);
        $email = 'newTestEmployee@hrms.com';
        $this->actingAs($hr)->post(route('users.store'), [
            'name' => 'Jaideep kumar',
            'email' => $email,
            'role_id' => Role::where('name', Role::EMPLOYEE)->value('id'),
        ])->assertSessionHasNoErrors();
        $row = User::where('email', $email)->firstOrFail();
        $logs = AuditLog::where('auditable_type', User::class)->where('auditable_id', $row->id)->get();

        $this->assertSame(1, $logs->count());
        $this->assertSame('created', $logs->first()->action);
        $this->assertSame($hr->id, $logs->first()->user_id);
        $this->assertSame(null, $logs->first()->old_values);
        $new_values = $logs->first()->new_values;
        $this->assertSame($email, $new_values['email']);
        $this->assertSame('Jaideep kumar', $new_values['name']);
        $this->assertArrayNotHasKey('password', $new_values);
    }

    public function test_updating_an_employee_logs_exact_old_and_new_phone(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id, 'phone' => '9900990090']);

        $this->actingAs($hr)->put(route('employees.update', $row->id), [
            'phone' => '1001100111',
            'date_of_joining' => $row->date_of_joining,
        ])->assertSessionHasNoErrors();
        $query = AuditLog::where('auditable_type', Employee::class)
            ->where('auditable_id', $row->id)->where('action', 'updated');
        $count = $query->count();
        $this->assertSame(1, $count);
        $log = $query->firstOrFail();
        $this->assertSame('updated', $log->action);
        $this->assertSame(['phone' => '1001100111'], $log->new_values);
        $this->assertSame(['phone' => '9900990090'], $log->old_values);
    }

    public function test_password_change_never_stores_the_hash(): void
    {
        $user = $this->makeUser(Role::EMPLOYEE, ['must_reset_password' => true]);
        $this->actingAs($user)->post(route('password.change.update'), [
            'current_password' => 'password123',
            'password' => 'newPassword123',
            'password_confirmation' => 'newPassword123',
        ])->assertRedirectToRoute('dashboard')->assertSessionHasNoErrors();
        $query = AuditLog::where('auditable_type', User::class)->where('auditable_id', $user->id)->where('action', 'updated');
        $count = $query->count();
        $this->assertSame(1, $count);
        $log = $query->firstOrFail();
        $this->assertTrue(Hash::check('newPassword123', $user->fresh()->password));
        $this->assertArrayNotHasKey('password', $log->new_values);
        $this->assertArrayNotHasKey('password', $log->old_values);
        $this->assertSame(['must_reset_password' => false], $log->new_values);
        $this->assertSame(['must_reset_password' => true], $log->old_values);
    }

    public function test_employee_creation_logs_only_one_row(): void
    {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $this->actingAs($hr)->post(route('employees.store'), [
            'user_id' => $user->id,
            'phone' => '9887655432',
            'date_of_joining' => '2026-11-30',
        ])->assertRedirectToRoute('employees.index')->assertSessionHasNoErrors();

        $row = Employee::where('user_id', $user->id)->firstOrFail();
        $query = AuditLog::where('auditable_type', Employee::class)->where('auditable_id', $row->id);
        $count = $query->count();
        $this->assertSame(1, $count);

        $log = $query->firstOrFail();
        $this->assertSame('created', $log->action);
        $this->assertSame(null, $log->old_values);
        $this->assertSame('9887655432', $log->new_values['phone']);
        $this->assertArrayNotHasKey('updated_at', $log->new_values);
        $this->assertArrayNotHasKey('employee_code', $log->new_values);
    }

    public function test_saving_identical_values_writes_no_audit_row_http_version() : void {
        $hr = $this->makeUser(Role::HR);
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id, 'phone' => '9900990090']);
        $this->actingAs($hr)->put(route('employees.update', $row->id), [
            'phone' => '9900990090',
            'date_of_joining' => $row->date_of_joining->format('Y-m-d')
        ])->assertSessionHasNoErrors();

        $query = AuditLog::where('auditable_type', Employee::class)->where('auditable_id', $row->id)->where('action','updated');
        $count = $query->count();
        $this->assertSame(0, $count);

    }

    public function test_saving_with_no_changes_writes_no_audit_row(): void
    {
        $user = $this->makeUser(Role::EMPLOYEE);
        $row = Employee::factory()->create(['user_id' => $user->id]);
        $query = AuditLog::where('auditable_type', Employee::class)->where('auditable_id', $row->id);
        $this->assertSame(1, $query->count());
        $row->save();
        $this->assertSame(1, $query->count());
    }
}
