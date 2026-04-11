<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cta_category_title',
        'items', // JSON array of { title, description }
    ];

    protected $casts = [
        'items' => 'array',
    ];

    // ── Belongs to CtaCategory via title ───────────────────────
    public function category()
    {
        return $this->belongsTo(CtaCategory::class, 'cta_category_title', 'title');
    }
}