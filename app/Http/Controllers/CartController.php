<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        return response()->json([
            'items' => $cart ? $cart->items : []
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0'
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => Auth::id()],
            ['items' => $request->items]
        );

        return response()->json([
            'success' => true,
            'message' => 'Cart saved successfully'
        ]);
    }

    public function destroy()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}