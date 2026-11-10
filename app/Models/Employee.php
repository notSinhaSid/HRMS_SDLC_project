<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class Employee extends Model
{
    protected $fillable = [
        'department_id',
        'designation_id',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'date_of_joining',
        'date_of_leaving',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'date_of_joining' => 'date',
            'date_of_leaving' => 'date',
            'date_of_birth' => 'date',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
