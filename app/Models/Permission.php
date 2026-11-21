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

    public const DEPARTMENT_VIEW = 'department.view';

    public const DEPARTMENT_CREATE = 'department.create';

    public const DEPARTMENT_UPDATE = 'department.update';

    public const DESIGNATION_VIEW = 'designation.view';

    public const DESIGNATION_CREATE = 'designation.create';

    public const DESIGNATION_UPDATE = 'designation.update';

    public static function employee(): array
    {
        return [
            self::EMPLOYEE_VIEW,
            self::EMPLOYEE_CREATE,
            self::EMPLOYEE_UPDATE,
            self::EMPLOYEE_DELETE,
        ];
    }

    public static function department(): array
    {
        return [
            self::DEPARTMENT_VIEW,
            self::DEPARTMENT_CREATE,
            self::DEPARTMENT_UPDATE,
        ];
    }

    public static function designation(): array
    {
        return [
            self::DESIGNATION_VIEW,
            self::DESIGNATION_CREATE,
            self::DESIGNATION_UPDATE,
        ];
    }

    public static function slugs(): array
    {
        return [...self::employee(), ...self::department(), ...self::designation()];
    }

    protected $fillable = ['name'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
