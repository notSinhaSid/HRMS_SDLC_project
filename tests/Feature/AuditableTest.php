<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\Concerns\CreateUsers;
use Tests\TestCase;

class AuditableTest extends TestCase
{
    use RefreshDatabase, CreateUsers;

    #[Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_creating_a_user_logs_one_created_row_without_password() : void {
        $hr = $this->makeUser(Role::HR);
        $email = "newTestEmployee@hrms.com";
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
}
