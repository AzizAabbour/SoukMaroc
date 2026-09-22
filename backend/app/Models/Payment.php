<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'method', 'status', 'amount', 'transaction_id', 'metadata'];

    protected $casts = ['amount' => 'decimal:2', 'metadata' => 'array'];

    public function order() { return $this->belongsTo(Order::class); }
}
