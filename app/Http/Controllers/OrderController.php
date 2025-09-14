<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        // Decode items if it comes as JSON string
        if ($request->has('items') && is_string($request->items)) {
            $decoded = json_decode($request->items, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge(['items' => $decoded]);
            }
        }
    
        // Validate basic cart
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0|max:50000',
            'payment_method' => 'required|string|in:wallet,loan',
        ]);
    
        // Extra validation if loan
        if ($request->payment_method === 'loan') {
            $request->validate([
                'bvn' => 'required|string|size:11',
                'repayment_plan' => 'required|string|in:weekly,bi-weekly,monthly',
                'repayment_amount' => 'required|numeric|min:1',
                'bill_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'bankStatement' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            ]);
        }
    
        // Validate items exist and prices are correct
        $foodIds = collect($request->items)->pluck('id');
        $foods = Food::whereIn('id', $foodIds)->get()->keyBy('id');
    
        $calculatedTotal = 0;
        foreach ($request->items as $item) {
            $food = $foods->get($item['id']);
            if (!$food) {
                return response()->json(['success' => false, 'message' => 'One or more items are no longer available'], 400);
            }
            if ($food->amount != $item['price']) {
                return response()->json(['success' => false, 'message' => 'Price mismatch detected. Please refresh and try again.'], 400);
            }
            $calculatedTotal += $item['qty'] * $item['price'];
        }
    
        if (abs($calculatedTotal - $request->total_amount) > 0.01) {
            return response()->json(['success' => false, 'message' => 'Total amount mismatch. Please refresh and try again.'], 400);
        }
    
        try {
            DB::beginTransaction();
    
            $has_paid_delivery_fee = 'no';
            $extra_fee = 1000;
    
            if ($request->payment_method == 'wallet') {
                User::where('id', Auth::id())->decrement('wallet_balance', $request->total_amount + $extra_fee);
                $has_paid_delivery_fee = 'yes';
                $reference = strtoupper('Wallet') . '_' . Str::uuid();
    
                DB::table('payments')->insert([
                    'user_id'    => Auth::id(),
                    'package'    => 'purchase',
                    'reference'  => $reference,
                    'amount'     => $request->total_amount + $extra_fee,
                    'status'     => 'success',
                    'gateway'    => 'wallet',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Handle uploads if loan
            $utilityBillFile = null;
            $bankStatement = null;
    
            if ($request->payment_method === 'loan') {
                if ($request->hasFile('bill_image')) {
                    $file = $request->file('bill_image');
                    $utilityBillFileName = time() . '_utility.' . $file->getClientOriginalExtension();
                
                    $utilityBillPath = public_path('uploads/utility_bills');
                    if (!file_exists($utilityBillPath)) {
                        mkdir($utilityBillPath, 0755, true);
                    }
                
                    $file->move($utilityBillPath, $utilityBillFileName);
                
                    // Save full path
                    $utilityBillFile = $utilityBillPath . '/' . $utilityBillFileName;
                }
                
                if ($request->hasFile('bankStatement')) {
                    $file = $request->file('bankStatement');
                    $bankStatementFileName = time() . '_bank.' . $file->getClientOriginalExtension();
                
                    $bankStatementPath = public_path('uploads/bank_statements');
                    if (!file_exists($bankStatementPath)) {
                        mkdir($bankStatementPath, 0755, true);
                    }
                
                    $file->move($bankStatementPath, $bankStatementFileName);
                
                    // Save full path
                    $bankStatement = $bankStatementPath . '/' . $bankStatementFileName;
                }
                
            }
    
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $request->total_amount,
                'items' => $request->items,
                'notes' => $request->notes,
                'status' => 'pending',
                'delivery_address' => $request->address,
                'payment_method' => $request->payment_method,
                'repayment_plan' => $request->repayment_plan ?? null,
                'has_paid_delivery_fee' => $has_paid_delivery_fee,
                'utility_bill_file' => $utilityBillFile,
                'bank_statement' => $bankStatement,
                'bvn' => $request->bvn,
                'repayment_amount' => $request->repayment_amount,
            ]);
    
            // Loan balance update
            $update_loan_amount  = $request->payment_method === 'loan' ? $request->total_amount : 0;
    
            // Clear user's cart
            Cart::where('user_id', Auth::id())->delete();
    
            User::where('id', Auth::id())->update([
                'last_payment_method' => $request->payment_method,
                'home_address' => $request->address
            ]);
    
            if ($update_loan_amount > 0) {
                User::where('id', Auth::id())->increment('loan_balance', $update_loan_amount);
            }
    
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
                'message' => 'Failed to place order. Please try again. ' . $e->getMessage()
            ], 500);
        }
    }
    



    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user_new.order', compact('orders'));
    }

    public function show($order)
    {

        $order = Order::where('order_number', '=', $order)->first();
        return view('user_new.order_detail', compact('order'));
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
