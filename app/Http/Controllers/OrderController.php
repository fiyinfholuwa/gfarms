<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0|max:50000',
            'notes' => 'nullable|string|max:500'
        ]);

        // Validate items exist and prices are correct
        $foodIds = collect($request->items)->pluck('id');
        $foods = Food::whereIn('id', $foodIds)->get()->keyBy('id');
        
        $calculatedTotal = 0;
        foreach ($request->items as $item) {
            $food = $foods->get($item['id']);
            if (!$food) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more items are no longer available'
                ], 400);
            }
            
            if ($food->amount != $item['price']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Price mismatch detected. Please refresh and try again.'
                ], 400);
            }
            
            $calculatedTotal += $item['qty'] * $item['price'];
        }

        if (abs($calculatedTotal - $request->total_amount) > 0.01) {
            return response()->json([
                'success' => false,
                'message' => 'Total amount mismatch. Please refresh and try again.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $request->total_amount,
                'items' => $request->items,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Clear user's cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.'. $e->getMessage()
            ], 500);
        }
    }


    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    public function show($order)
    {
        
        $order = Order::where('order_number', '=', $order)->first();
        return view('user.orders_detail', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation of pending or confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }
}