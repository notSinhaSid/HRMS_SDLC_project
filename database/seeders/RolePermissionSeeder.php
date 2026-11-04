<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            Role::HR => Permission::employee(),
            Role::MANAGER => [],
            Role::EMPLOYEE => [],
        ];

        foreach ($map as $roleName => $permissionNames) {
            $role = Role::where('name', $roleName)->firstOrFail();
            $ids = Permission::whereIn('name', $permissionNames)->pluck('id');

            $role->permissions()->syncWithoutDetaching($ids);
        }
    }
}
