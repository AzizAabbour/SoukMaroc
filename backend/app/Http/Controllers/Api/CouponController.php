<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Code promo invalide.'
            ], 404);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Ce code promo a expiré ou atteint sa limite d\'utilisation.'
            ], 422);
        }

        if ($request->subtotal < $coupon->min_order) {
            return response()->json([
                'valid' => false,
                'message' => "Ce code promo nécessite un montant minimum de {$coupon->min_order} MAD."
            ], 422);
        }

        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($request->subtotal * $coupon->value) / 100;
        } else {
            $discount = $coupon->value;
        }

        return response()->json([
            'valid' => true,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => round($discount, 2),
            'message' => 'Code promo appliqué avec succès !',
        ]);
    }
}
