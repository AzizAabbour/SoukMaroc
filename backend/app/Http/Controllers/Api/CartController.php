<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private function getOrCreateCart(Request $request)
    {
        $user = $request->user('sanctum');
        $sessionId = $request->header('X-Session-ID') ?? $request->input('session_id');

        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            // Merge guest cart if session_id provided
            if ($sessionId) {
                $guestCart = Cart::where('session_id', $sessionId)->first();
                if ($guestCart && $guestCart->id !== $cart->id) {
                    foreach ($guestCart->items as $item) {
                        $existing = $cart->items()->where('product_id', $item->product_id)->first();
                        if ($existing) {
                            $existing->update(['quantity' => $existing->quantity + $item->quantity]);
                        } else {
                            $cart->items()->create([
                                'product_id' => $item->product_id,
                                'variant_id' => $item->variant_id,
                                'quantity' => $item->quantity,
                            ]);
                        }
                    }
                    $guestCart->delete();
                }
            }
            return $cart;
        }

        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
        }

        $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        return $cart;
    }

    public function index(Request $request)
    {
        $cart = $this->getOrCreateCart($request);
        $cart->load(['items.product.images', 'items.product.seller', 'items.variant']);

        $subtotal = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->price;
            if ($item->variant && $item->variant->price_adjustment) {
                $price += $item->variant->price_adjustment;
            }
            $subtotal += $price * $item->quantity;
        }

        return response()->json([
            'cart_id' => $cart->id,
            'session_id' => $cart->session_id,
            'items' => $cart->items,
            'item_count' => $cart->items->sum('quantity'),
            'subtotal' => $subtotal,
            'shipping' => $subtotal > 300 ? 0 : 35, // Free shipping over 300 DH
            'total' => $subtotal + ($subtotal > 300 ? 0 : ($subtotal > 0 ? 35 : 0)),
        ]);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $cart = $this->getOrCreateCart($request);
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Stock insuffisant pour ce produit.'
            ], 422);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Produit ajouté au panier',
            'cart_id' => $cart->id,
            'session_id' => $cart->session_id,
        ]);
    }

    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'status' => 'success',
            'message' => 'Quantité mise à jour',
        ]);
    }

    public function removeItem($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produit retiré du panier',
        ]);
    }

    public function clearCart(Request $request)
    {
        $cart = $this->getOrCreateCart($request);
        $cart->items()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Panier vidé',
        ]);
    }
}
