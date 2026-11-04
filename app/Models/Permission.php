<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    public const EMPLOYEE_VIEW = 'employee.view';

    public const EMPLOYEE_CREATE = 'employee.create';

    public const EMPLOYEE_UPDATE = 'employee.update';

    public const EMPLOYEE_DELETE = 'employee.delete';

    public static function employee(): array
    {
        return [
            self::EMPLOYEE_VIEW,
            self::EMPLOYEE_CREATE,
            self::EMPLOYEE_UPDATE,
            self::EMPLOYEE_DELETE,
        ];
    }

    public static function slugs(): array
    {
        return [...self::employee()];
    }

    protected $fillable = ['name'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
