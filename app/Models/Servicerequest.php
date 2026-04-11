<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'service_category',
        'description',
        'budget',
        'timeline',
        'files',
        'status',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    // ── Scopes ─────────────────────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ── Status badge helper ────────────────────────────────────
    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'reviewed'  => 'primary',
            'completed' => 'success',
            default     => 'secondary',
        };
    }
}