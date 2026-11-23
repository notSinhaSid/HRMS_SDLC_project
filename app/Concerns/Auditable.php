<?php

namespace App\Concerns;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;

trait Auditable
{
    protected static function bootAuditable():void {
        static::created(function($model) {
            $model->auditLogs()->create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'old_values' => null,
                'new_values' => Arr::except(
                    $model->getAttributes(),
                    $model->auditExcluded()
                ),
            ]);
        });
    }

    public function auditLogs() : MorphMany {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function auditExcluded(): array {
        return array_merge(['updated_at'], $this->auditExclude ?? []);
    }
}
