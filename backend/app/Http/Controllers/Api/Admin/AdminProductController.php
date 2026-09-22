<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['seller', 'category', 'brand'])
            ->latest()
            ->paginate(15);

        return response()->json($products);
    }

    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);

        return response()->json([
            'status' => 'success',
            'message' => 'Statut du produit mis à jour',
            'is_active' => $product->is_active,
        ]);
    }

    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_featured' => !$product->is_featured]);

        return response()->json([
            'status' => 'success',
            'message' => 'Statut vedette mis à jour',
            'is_featured' => $product->is_featured,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produit supprimé',
        ]);
    }
}
