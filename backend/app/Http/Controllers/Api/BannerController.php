<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Promotion;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $promotions = Promotion::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->get();

        return response()->json([
            'banners' => $banners,
            'promotions' => $promotions,
        ]);
    }
}
