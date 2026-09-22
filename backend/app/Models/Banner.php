<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title_fr', 'title_ar', 'subtitle_fr', 'subtitle_ar',
        'image', 'link', 'position', 'button_text_fr', 'button_text_ar',
        'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopePosition($query, $position) { return $query->where('position', $position); }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? ($this->title_ar ?? $this->title_fr) : $this->title_fr;
    }
}
