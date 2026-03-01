<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    // ─── Static helpers ───────────────────────────────────────

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = static::getAllCached();

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, mixed $value, string $type = 'text', string $group = 'general'): void
    {
        $stored = is_array($value) ? json_encode($value) : (string) $value;

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $stored, 'type' => $type, 'group' => $group]
        );

        static::clearCache();
    }

    public static function setMany(array $data, string $group = 'general'): void
    {
        foreach ($data as $key => $value) {
            if ($value !== null) {
                static::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_array($value) ? json_encode($value) : (string) $value, 'group' => $group]
                );
            }
        }

        static::clearCache();
    }

    public static function getAllCached(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('site_settings');
    }

    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}
