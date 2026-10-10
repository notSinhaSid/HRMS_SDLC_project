<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = config('hrms.super_admin.name');
        $email = config('hrms.super_admin.email');
        $password = config('hrms.super_admin.password');

        if (! $email || ! $password) {
            throw new \RuntimeException('SUPERADMIN_EMAIL OR SUPERADMIN_PASSWORD must be set in .env file');
        }

        $role = Role::where('name', Role::SUPER_ADMIN)->firstOrFail();
        $user = User::firstOrNew(['email' => $email]);

        if (! $user->exists) {
            $user->forceFill([
                'role_id' => $role->id,
                'name' => $name,
                'password' => Hash::make($password),
                'status' => 'active',
                'must_reset_password' => false,
            ])->save();
        }
    }
}
