<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'address', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);
        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'address', 'items.product', 'items.seller', 'payment'])
            ->findOrFail($id);

        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        if ($request->status === 'delivered') {
            $order->update(['payment_status' => 'paid']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Statut de la commande mis à jour',
            'order' => $order,
        ]);
    }
}
