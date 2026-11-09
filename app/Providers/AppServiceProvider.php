<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This is for password rules
        Password::defaults(fn () => Password::min(8)->mixedCase());
        Gate::before(function (User $user) {
            if ($user->role?->name === Role::SUPER_ADMIN) {
                return true;
            }

            return null;
        });

        foreach (Permission::slugs() as $slug) {
            Gate::define($slug, fn (User $user) => $user->hasPermission($slug));
        }

    }
}
