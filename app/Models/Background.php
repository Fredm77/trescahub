<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Background extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'go_to',
        'button_text',
    ];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'thumbnail'   => 'array',
        'go_to'       => 'array',
        'button_text' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($background) {
            if (empty($background->slug)) {
                $background->slug = Str::slug(
                    is_array($background->title) ? ($background->title[0] ?? '') : $background->title
                );
            }
        });
        static::updating(function ($background) {
            if (empty($background->slug)) {
                $background->slug = Str::slug(
                    is_array($background->title) ? ($background->title[0] ?? '') : $background->title
                );
            }
        });
    }
}