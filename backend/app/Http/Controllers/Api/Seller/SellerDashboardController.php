<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function stats(Request $request)
    {
        $seller = $request->user()->seller;

        if (!$seller) {
            return response()->json(['message' => 'Non autorisé. Compte vendeur non trouvé.'], 403);
        }

        $totalSales = OrderItem::where('seller_id', $seller->id)->sum('price');
        $totalOrders = OrderItem::where('seller_id', $seller->id)->distinct('order_id')->count('order_id');
        $totalProducts = Product::where('seller_id', $seller->id)->count();

        $recentItems = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', $seller->id)
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'seller' => $seller,
            'stats' => [
                'total_sales' => round($totalSales, 2),
                'total_orders' => $totalOrders,
                'total_products' => $totalProducts,
                'rating' => $seller->rating,
            ],
            'recent_orders' => $recentItems,
        ]);
    }
}
