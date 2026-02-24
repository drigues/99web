<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'package_type',
        'budget',
        'project_description',
        'has_domain',
        'has_hosting',
        'current_website',
        'deadline',
        'status',
        'notes',
    ];

    protected $casts = [
        'has_domain'  => 'boolean',
        'has_hosting' => 'boolean',
        'deadline'    => 'date',
    ];

    public function scopeNovo($query)
    {
        return $query->where('status', 'novo');
    }

    public function scopeByPackage($query, string $type)
    {
        return $query->where('package_type', $type);
    }
}
