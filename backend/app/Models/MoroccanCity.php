<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoroccanCity extends Model
{
    protected $fillable = ['name_fr', 'name_ar', 'region_fr', 'region_ar'];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_fr;
    }

    public function getRegionAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->region_ar : $this->region_fr;
    }
}
