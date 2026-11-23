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

        static::updated(function($model) {
            $changes = Arr::except($model->getChanges(), ['updated_at']);
            if(empty($changes)) {
                return;
            }
            $new = Arr::except($changes, $model->auditExcluded());
            $old = Arr::only($model->getOriginal(), array_keys($changes));
            $old = Arr::except($old , $model->auditExcluded());

            if(empty(array_diff(array_keys($changes), $model->auditSkipWhenOnly()))){
                return;
            }

            $model->auditLogs()->create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'old_values' => $old,
                'new_values' => $new,
            ]);
        });
    }

    public function auditLogs() : MorphMany {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function auditExcluded(): array {
        return array_merge(['updated_at'], $this->auditExclude ?? []);
    }

    public function auditSkipWhenOnly(): array {
        return $this->auditSkipOnly ?? [];
    }
}
