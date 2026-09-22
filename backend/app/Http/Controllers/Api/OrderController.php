<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.product.images', 'items.seller', 'address'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with(['items.product.images', 'items.seller', 'address', 'payment'])
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->orWhere('order_number', $id)
            ->firstOrFail();

        return response()->json($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,card,cmi',
            'coupon_code' => 'nullable|string',
            'cart_id' => 'nullable|exists:carts,id',
            'buy_now' => 'nullable|array',
            'buy_now.product_id' => 'required_with:buy_now|exists:products,id',
            'buy_now.quantity' => 'required_with:buy_now|integer|min:1',
            'buy_now.variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $user = $request->user();
        $address = $user->addresses()->findOrFail($request->address_id);

        return DB::transaction(function() use ($request, $user, $address) {
            $itemsToOrder = [];
            $subtotal = 0;

            if ($request->filled('buy_now')) {
                $product = Product::with('seller')->findOrFail($request->buy_now['product_id']);
                $price = $product->price;
                $itemsToOrder[] = [
                    'product' => $product,
                    'seller_id' => $product->seller_id,
                    'quantity' => $request->buy_now['quantity'],
                    'price' => $price,
                    'variant_id' => $request->buy_now['variant_id'] ?? null,
                ];
                $subtotal = $price * $request->buy_now['quantity'];
            } else {
                $cart = Cart::where('user_id', $user->id)
                    ->orWhere('id', $request->cart_id)
                    ->with(['items.product.seller', 'items.variant'])
                    ->first();

                if (!$cart || $cart->items->isEmpty()) {
                    return response()->json(['message' => 'Le panier est vide.'], 422);
                }

                foreach ($cart->items as $item) {
                    $price = $item->product->price;
                    if ($item->variant && $item->variant->price_adjustment) {
                        $price += $item->variant->price_adjustment;
                    }

                    $itemsToOrder[] = [
                        'product' => $item->product,
                        'seller_id' => $item->product->seller_id,
                        'quantity' => $item->quantity,
                        'price' => $price,
                        'variant_id' => $item->variant_id,
                    ];

                    $subtotal += $price * $item->quantity;
                }
            }

            // Coupon discount
            $discount = 0;
            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
                if ($coupon && $coupon->isValid()) {
                    if ($coupon->type === 'percentage') {
                        $discount = ($subtotal * $coupon->value) / 100;
                    } else {
                        $discount = $coupon->value;
                    }
                    $coupon->increment('uses_count');
                }
            }

            $shippingCost = $subtotal > 300 ? 0 : 35; // Free shipping over 300 MAD
            $total = max(0, $subtotal - $discount + $shippingCost);

            // Create Order
            $orderNumber = 'MAR-' . strtoupper(Str::random(3)) . '-' . rand(10000, 99999);

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'seller_id' => $itemsToOrder[0]['seller_id'] ?? null,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'paid',
                'notes' => $request->notes ?? 'Paiement à la livraison',
            ]);

            // Create Order items & reduce stock
            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'seller_id' => $item['seller_id'],
                    'variant_id' => $item['variant_id'],
                    'variant_info' => $item['variant_id'] ? 'Variante' : null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Reduce stock
                $item['product']->decrement('stock', $item['quantity']);
            }

            // Create Payment record
            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'completed',
                'amount' => $total,
                'transaction_id' => 'TXN-' . rand(100000, 999999),
            ]);

            // Empty user cart if ordered from cart
            if (!$request->filled('buy_now')) {
                Cart::where('user_id', $user->id)->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Commande passée avec succès',
                'order' => $order->load(['items.product.images', 'address', 'payment']),
            ], 201);
        });
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($id);

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'Impossible d\'annuler une commande déjà en cours d\'expédition.'
            ], 422);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'status' => 'success',
            'message' => 'Commande annulée avec succès',
        ]);
    }
}
