<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'current_website',
        'preferred_date',
        'preferred_time',
        'meeting_type',
        'objectives',
        'status',
        'admin_notes',
        'confirmed_date',
        'confirmed_time',
    ];

    protected $casts = [
        'preferred_date'  => 'date',
        'confirmed_date'  => 'date',
    ];

    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeConfirmado($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function confirm(string $date, string $time): void
    {
        $this->update([
            'status'         => 'confirmado',
            'confirmed_date' => $date,
            'confirmed_time' => $time,
        ]);
    }
}
