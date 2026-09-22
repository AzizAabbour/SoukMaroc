<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;

        $items = OrderItem::with(['order.user', 'order.address', 'product'])
            ->where('seller_id', $seller->id)
            ->latest()
            ->paginate(15);

        return response()->json($items);
    }
}
