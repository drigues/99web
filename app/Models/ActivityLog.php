<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
    ];

    // ─── Relationships ────────────────────────────────────────

    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_id');
    }

    // ─── Static helper ────────────────────────────────────────

    public static function record(
        string $action,
        ?Model $model = null,
        ?string $description = null
    ): void {
        $adminId = Auth::guard('admin')->id();

        static::create([
            'admin_id'   => $adminId,
            'action'     => $action,
            'model_type' => $model ? class_basename($model) : null,
            'model_id'   => $model?->getKey(),
            'description' => $description,
            'ip_address' => Request::ip(),
        ]);
    }

    // ─── Display helpers ──────────────────────────────────────

    public function actionLabel(): string
    {
        return match ($this->action) {
            'created'   => 'Criado',
            'updated'   => 'Atualizado',
            'deleted'   => 'Eliminado',
            'published' => 'Publicado',
            'login'     => 'Login',
            'export'    => 'Exportado',
            default     => ucfirst($this->action),
        };
    }

    public function actionColor(): string
    {
        return match ($this->action) {
            'created'   => 'text-emerald-400 bg-emerald-500/10',
            'updated'   => 'text-blue-400 bg-blue-500/10',
            'deleted'   => 'text-red-400 bg-red-500/10',
            'published' => 'text-violet-400 bg-violet-500/10',
            'login'     => 'text-zinc-400 bg-zinc-500/10',
            'export'    => 'text-amber-400 bg-amber-500/10',
            default     => 'text-zinc-400 bg-zinc-800',
        };
    }
}
