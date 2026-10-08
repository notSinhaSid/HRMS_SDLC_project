<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public const SUPER_ADMIN = 'super_admin';

    public const HR = 'hr';

    public const MANAGER = 'manager';

    public const EMPLOYEE = 'employee';

    protected $fillable = ['name'];

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
}
