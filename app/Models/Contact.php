<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'website_url',
        'message',
        'source',
        'status',
        'notes',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function scopeNovo($query)
    {
        return $query->where('status', 'novo');
    }

    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }

    public function markAsResponded(): void
    {
        $this->update([
            'status'       => 'respondido',
            'responded_at' => now(),
        ]);
    }
}
