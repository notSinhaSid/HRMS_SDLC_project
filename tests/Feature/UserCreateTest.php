<?php

namespace Tests\Feature;

use App\Mail\TempPasswordMail;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_employee_gets_403_on_create_user_page(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);

        $this->actingAs($employee)->get(route('users.create'))->assertForbidden();
    }

    public function test_hr_gets_200_on_create_user_page(): void
    {
        $hr = $this->makeUser(Role::HR);

        $this->actingAs($hr)->get(route('users.create'))->assertOk();
    }

    public function test_inactive_users_gets_blocked_at_login(): void
    {
        $user = $this->makeUser(Role::EMPLOYEE, [
            'name' => 'Sarvesh Yadav',
            'email' => 'sarveshEmployee@hrms.com',
            'status' => 'inactive',
        ]);
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertSessionHasErrors('message');
        $this->assertGuest();
    }

    public function test_flagged_user_get_forced_redirect_to_change_password(): void
    {
        $forceChangePassword = $this->makeUser(Role::MANAGER, ['must_reset_password' => true]);

        $this->actingAs($forceChangePassword)->get(route('dashboard'))->assertRedirectToRoute('password.change');
    }

    public function test_super_admin_bypasses_permission_check(): void
    {
        $superadmin = User::where('email', config('hrms.super_admin.email'))->firstOrFail();

        $this->actingAs($superadmin)->get(route('users.create'))->assertOk();
    }

    public function test_hr_cannot_assign_super_admin_role(): void
    {
        Mail::fake();
        $hr = $this->makeUser(Role::HR);

        $superAdminRoleId = Role::where('name', Role::SUPER_ADMIN)->value('id');

        $this->actingAs($hr)->post(route('users.store'), [
            'name' => 'Evil User',
            'email' => 'evilhr@hrms.com',
            'role_id' => $superAdminRoleId,
        ])->assertSessionHasErrors('role_id');

        $this->assertDatabaseMissing('users', ['email' => 'evilhr@hrms.com']);
        Mail::assertNothingSent();
    }

    public function test_hr_can_create_normal_employee(): void
    {
        Mail::fake();
        $hr = $this->makeUser(Role::HR);
        $email = 'good@hrms.com';

        $this->actingAs($hr)->post(route('users.store'), [
            'name' => 'Good employee',
            'email' => $email,
            'role_id' => Role::where('name', Role::EMPLOYEE)->value('id'),
        ])->assertRedirectToRoute('users.create')->assertSessionHas('status');

        $this->assertDatabaseHas('users', ['email' => $email, 'status' => 'active', 'must_reset_password' => true]);

        Mail::assertSent(TempPasswordMail::class, 1);
        $mail = Mail::sent(TempPasswordMail::class)->first();
        $this->assertNotNull($mail);
        $this->assertTrue($mail->hasTo($email));

        $storedHash = User::where('email', $email)->value('password');
        $this->assertTrue(Hash::check($mail->tmpPassword, $storedHash));
    }

    public function test_user_is_not_saved_when_mail_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new Exception('mail down'));
        $email = 'good@hrms.com';
        $hr = $this->makeUser(Role::HR);
        $this->from(route('users.create'))->actingAs($hr)->post(route('users.store'), [
            'name' => 'Good employee',
            'email' => $email,
            'role_id' => Role::where('name', Role::EMPLOYEE)->value('id'),
        ])->assertRedirect(route('users.create'))->assertSessionHasErrors('message')->assertSessionHasInput('email', $email);

        $this->assertDatabaseMissing('users', ['email' => $email]);

    }
}
