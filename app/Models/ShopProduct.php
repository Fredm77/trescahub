<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShopProduct extends Model
{
    use HasFactory;

    protected $table = 'shop_products';

    protected $fillable = [
        'product_name',
        'slug',
        'status',
        'is_popular',
        'description',
        'price',
        'working_days',
        'features',
        'specifications',
        'thumbnail',
        'images',
        'shop_category_id',
        'subcategory_id',
    ];

    protected $casts = [
        'is_popular'       => 'boolean',
        'features'         => 'array',
        'specifications'   => 'array',
        'images'           => 'array',
        'price'            => 'decimal:2',
        'shop_category_id' => 'integer',
        'subcategory_id'   => 'integer',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->product_name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->product_name);
            }
        });
    }

    /**
     * Route model binding via slug.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Belongs to a parent ShopCategory (unsignedBigInteger FK).
     */
    public function category()
    {
        return $this->belongsTo(Shopcategory::class, 'shop_category_id');
    }

    /**
     * Belongs to a subcategory ShopCategory (unsignedBigInteger FK).
     */
    public function subcategory()
    {
        return $this->belongsTo(ShopCategory::class, 'subcategory_id');
    }

    /**
     * Helper: formatted price in RWF.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'RWF ' . number_format($this->price, 0, '.', ',');
    }

    /**
     * Helper: human-readable status.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'in_stock' ? 'In Stock' : 'Out of Stock';
    }
}