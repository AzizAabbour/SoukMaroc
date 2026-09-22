<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalSellers = Seller::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $recentOrders = Order::with(['user', 'address'])
            ->latest()
            ->take(10)
            ->get();

        $topSellers = Seller::orderBy('rating', 'desc')->take(5)->get();

        return response()->json([
            'stats' => [
                'total_sales' => round($totalSales, 2),
                'total_orders' => $totalOrders,
                'total_products' => $totalProducts,
                'total_users' => $totalUsers,
                'total_sellers' => $totalSellers,
                'pending_orders' => $pendingOrders,
            ],
            'recent_orders' => $recentOrders,
            'top_sellers' => $topSellers,
        ]);
    }
}
