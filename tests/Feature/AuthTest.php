<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase, CreateUsers;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

    }

    public function test_inactive_user_is_blocked_at_login(): void
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

    public function test_flagged_user_is_redirect_to_change_password(): void
    {
        $forceChangePassword = $this->makeUser(Role::MANAGER, ['must_reset_password' => true]);

        $this->actingAs($forceChangePassword)->get(route('dashboard'))->assertRedirectToRoute('password.change');
    }

    /* public function test_login_is_locked_after_five_failed_attempts(): void
    {
        //
    } */
}
