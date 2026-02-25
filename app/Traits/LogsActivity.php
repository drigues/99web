<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            ActivityLog::record('created', $model, $model->activityDescription('created'));
        });

        static::updated(function ($model) {
            ActivityLog::record('updated', $model, $model->activityDescription('updated'));
        });

        static::deleted(function ($model) {
            ActivityLog::record('deleted', $model, $model->activityDescription('deleted'));
        });
    }

    /**
     * Override in the model to customise the log description.
     */
    public function activityDescription(string $action): string
    {
        $label = match ($action) {
            'created' => 'criou',
            'updated' => 'atualizou',
            'deleted' => 'eliminou',
            default   => $action,
        };

        $name = $this->title ?? $this->name ?? $this->subject ?? "#{$this->getKey()}";

        return ucfirst(class_basename($this)) . " {$label}: {$name}";
    }
}
