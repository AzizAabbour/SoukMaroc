<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'seller_id', 'variant_info', 'quantity', 'price', 'total'];

    protected $casts = [
        'variant_info' => 'array',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function order() { return $this->belongsTo(Order::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function seller() { return $this->belongsTo(Seller::class); }
}
