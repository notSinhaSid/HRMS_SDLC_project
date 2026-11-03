<?php

namespace Tests\Concerns;

use App\Models\Role;
use App\Models\User;

trait CreateUsers
{
    private function makeUser(string $roleName, array $overrides = []): User
    {
        return tap((new User)->forceFill(array_merge([
            'role_id' => Role::where('name', $roleName)->value('id'),
            'name' => 'Test User',
            'email' => $roleName.'@hrms.com',
            'password' => 'password123',
            'status' => 'active',
            'must_reset_password' => false,
        ], $overrides)))->save();
    }
}
