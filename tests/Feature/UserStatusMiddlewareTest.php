<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class UserStatusMiddlewareTest extends TestCase
{
    use CreateUsers, RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_inactive_users_are_redirect_back_to_login(): void
    {
        $user = $this->makeUser(Role::EMPLOYEE, ['status' => 'inactive']);
        $this->actingAs($user)->get(route('dashboard'))->assertRedirectToRoute('login')->assertSessionHasErrors('message');
        $this->assertGuest();
    }

    public function test_active_users_can_visit_auth_guarded_routes(): void
    {
        $user = $this->makeUser(Role::EMPLOYEE);
        $this->actingAs($user)->get(route('dashboard'))->assertSessionHasNoErrors()->assertOk();
        $this->assertAuthenticated();
    }
}
