<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment', 'is_approved'];

    protected $casts = ['is_approved' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }

    public function scopeApproved($query) { return $query->where('is_approved', true); }
}
