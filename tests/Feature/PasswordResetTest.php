<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_email_not_found_user_cannot_reset_password(): void
    {
        $this->post(route('password.email'), ['email' => 'testemail@test.com'])->assertSessionHasErrors('email');
    }

    public function test_inactive_user_cannot_reset_password(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE, ['status' => 'inactive']);

        $this->post(route('password.email'), [
            'email' => $employee->email,
        ])->assertSessionHasErrors('message');
    }

    public function test_valid_user_can_reset_password(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);
        $token = Password::createToken($employee);
        $newPassword = 'newPassword123';
        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $employee->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->assertRedirectToRoute('login');
        $this->assertFalse(Hash::check('password123', $employee->fresh()->password));
        $this->assertTrue(Hash::check($newPassword, $employee->fresh()->password));
    }

    public function test_reset_password_token_reuse_is_invalid(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);
        $token = Password::createToken($employee);
        $newPassword = 'newPassword123';

        $payload = [
            'token' => $token,
            'email' => $employee->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];
        $this->post(route('password.update'), $payload)->assertRedirectToRoute('login');

        $this->post(route('password.update'), $payload)->assertSessionHasErrors('message');
        $this->assertTrue(Hash::check($newPassword, $employee->fresh()->password));
    }

    public function test_user_deactivated_after_link_cannot_reset_password(): void
    {
        $employee = $this->makeUser(Role::EMPLOYEE);
        $token = Password::createToken($employee);

        $employee->forceFill(['status' => 'inactive'])->save();

        $newPassword = 'newPassword123';
        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $employee->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->assertSessionHasErrors('message');
        $this->assertTrue(Hash::check('password123', $employee->fresh()->password));
    }
}
