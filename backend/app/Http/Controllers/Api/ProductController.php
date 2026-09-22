<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['seller', 'category', 'brand', 'images'])
            ->where('is_active', true);

        // Search query
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name_fr', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('description_fr', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $childIds = $category->children()->pluck('id')->toArray();
                $categoryIds = array_merge([$category->id], $childIds);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Rating filter
        if ($request->filled('rating')) {
            $query->whereHas('seller', function($q) use ($request) {
                $q->where('rating', '>=', $request->rating);
            });
        }

        // Featured filter
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('created_at', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 16);
        $products = $query->paginate($perPage);

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::with([
            'seller.user', 
            'category', 
            'brand', 
            'images', 
            'variants', 
            'reviews.user'
        ])
        ->where('slug', $slug)
        ->orWhere('id', $slug)
        ->firstOrFail();

        // Increment views
        $product->increment('views_count');

        // Related products from same category
        $relatedProducts = Product::with(['images', 'seller'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(8)
            ->get();

        return response()->json([
            'product' => $product,
            'related' => $relatedProducts,
        ]);
    }

    public function featured()
    {
        $products = Product::with(['seller', 'category', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(12)
            ->get();

        return response()->json($products);
    }

    public function flashDeals()
    {
        $products = Product::with(['seller', 'category', 'images'])
            ->where('is_active', true)
            ->whereNotNull('old_price')
            ->whereColumn('old_price', '>', 'price')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($products);
    }

    public function searchSuggestions(Request $request)
    {
        $search = $request->get('q', '');
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('name_fr', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%");
            })
            ->take(6)
            ->get(['id', 'name_fr', 'name_ar', 'slug', 'price']);

        return response()->json($products);
    }
}
