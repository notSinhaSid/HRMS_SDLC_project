<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function PHPSTORM_META\map;

class Role extends Model
{
    public const SUPER_ADMIN = 'super_admin';

    public const HR = 'hr';

    public const MANAGER = 'manager';

    public const EMPLOYEE = 'employee';

    protected $fillable = ['name'];

    private const ASSIGNABLE = [self::SUPER_ADMIN => [self::HR, self::MANAGER, self::EMPLOYEE],
            self::HR => [self::MANAGER, self::EMPLOYEE],
            ];

    public static function slugs(): array
    {
        return [self::SUPER_ADMIN, self::HR, self::MANAGER, self::EMPLOYEE];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions->contains('name', $permission);
    }

    public function assignableRoles() {   
        $names = self::ASSIGNABLE[$this->name] ?? [];
        return self::whereIn('name', $names)->get();
    }
}
