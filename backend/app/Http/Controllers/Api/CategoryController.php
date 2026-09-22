<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['children'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json($categories);
    }

    public function show($slug)
    {
        $category = Category::with(['children', 'parent'])
            ->where('slug', $slug)
            ->firstOrFail();

        $childIds = $category->children()->pluck('id')->toArray();
        $categoryIds = array_merge([$category->id], $childIds);

        $products = $category->products()
            ->with(['seller', 'images'])
            ->where('is_active', true)
            ->paginate(16);

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
    }
}
