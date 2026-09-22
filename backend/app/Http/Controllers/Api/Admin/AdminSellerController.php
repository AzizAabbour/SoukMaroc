<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class AdminSellerController extends Controller
{
    public function index(Request $request)
    {
        $sellers = Seller::with('user')->withCount('products')->latest()->paginate(15);
        return response()->json($sellers);
    }

    public function toggleVerify($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['is_verified' => !$seller->is_verified]);

        return response()->json([
            'status' => 'success',
            'message' => 'Statut de vérification mis à jour',
            'is_verified' => $seller->is_verified,
        ]);
    }
}
