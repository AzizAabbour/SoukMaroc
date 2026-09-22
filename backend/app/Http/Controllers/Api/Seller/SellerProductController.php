<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $seller = $request->user()->seller;
        $products = Product::with(['category', 'images'])
            ->where('seller_id', $seller->id)
            ->latest()
            ->paginate(15);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_fr' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description_fr' => 'required|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|string',
        ]);

        $seller = $request->user()->seller;

        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name_fr' => $request->name_fr,
            'name_ar' => $request->name_ar ?? $request->name_fr,
            'slug' => Str::slug($request->name_fr) . '-' . rand(1000, 9999),
            'description_fr' => $request->description_fr,
            'description_ar' => $request->description_ar ?? $request->description_fr,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'stock' => $request->stock,
            'is_active' => true,
        ]);

        // Add primary image if provided or generate default SVG/placeholder image
        $imagePath = $request->image_url ?? 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=500';
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
            'is_primary' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Produit ajouté avec succès',
            'product' => $product->load('images'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        $request->validate([
            'name_fr' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->only([
            'name_fr', 'name_ar', 'category_id', 'brand_id',
            'description_fr', 'description_ar', 'price', 'old_price', 'stock', 'is_active'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Produit mis à jour',
            'product' => $product,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $seller = $request->user()->seller;
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produit supprimé',
        ]);
    }
}
