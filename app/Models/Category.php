<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'classification_name',
        'subcategory',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'classification_name' => 'array',
        'subcategory' => 'array',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all services for this category.
     * 
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'classification_name', 'id');
    }

    /**
     * Get the route key for implicit model binding.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}