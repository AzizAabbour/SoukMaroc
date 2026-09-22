<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = Wishlist::with(['product.images', 'product.seller'])
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json($wishlist);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = $request->user()->id;
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Produit retiré des favoris',
                'in_wishlist' => false,
            ]);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return response()->json([
            'status' => 'added',
            'message' => 'Produit ajouté aux favoris',
            'in_wishlist' => true,
        ]);
    }

    public function destroy(Request $request, $productId)
    {
        Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produit retiré des favoris',
        ]);
    }
}
