<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function indexForProduct($productId)
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->where('is_approved', true)
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $product = Product::findOrFail($productId);
        $userId = $request->user()->id;

        $review = Review::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => true,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Avis enregistré avec succès',
            'review' => $review->load('user'),
        ], 201);
    }
}
