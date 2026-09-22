<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $sellers = Seller::with('user')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return response()->json($sellers);
    }

    public function show($slug)
    {
        $seller = Seller::with(['user'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $productsCount = $seller->products()->where('is_active', true)->count();

        return response()->json([
            'seller' => $seller,
            'products_count' => $productsCount,
        ]);
    }

    public function products(Request $request, $slug)
    {
        $seller = Seller::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();

        $products = $seller->products()
            ->with(['category', 'images'])
            ->where('is_active', true)
            ->paginate(16);

        return response()->json($products);
    }
}
