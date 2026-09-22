<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title_fr', 'title_ar', 'description_fr', 'description_ar',
        'type', 'discount_percentage', 'starts_at', 'ends_at', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_product');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function scopeFlashDeals($query)
    {
        return $query->where('type', 'flash_deal');
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? ($this->title_ar ?? $this->title_fr) : $this->title_fr;
    }
}
