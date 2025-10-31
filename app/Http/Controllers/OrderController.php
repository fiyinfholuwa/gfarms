<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        if ($request->has('items') && is_string($request->items)) {
            $decoded = json_decode($request->items, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge(['items' => $decoded]);
            }
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0|max:5000000',
        ]);


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
            $orderId = Order::generateOrderNumber();
            Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderId,
                'total_amount' => $request->total_amount,
                'items' => $request->items,
                'notes' => $request->notes,
                'status' => 'pending',
                'phone_number' => $request->phone_number,
                'delivery_address' => $request->address,
                'payment_method' =>  "Online Payment",
                'repayment_plan' => $request->repayment_plan ?? null,
                'has_paid_delivery_fee' => "no",
                'utility_bill_file' => "",
                'bank_statement' => "",
                'bvn' => "",
                'repayment_amount' => 0,
            ]);
            Cart::where('user_id', Auth::id())->delete();
            DB::commit();

            return response()->json(self::startPayment($request->total_amount, $orderId ));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again. ' . $e->getMessage()
            ], 500);
        }
    }




    public static function startPayment($amount,$orderId)
{
    $user = Auth::user();
    $reference = 'FLW_' . strtoupper(Str::uuid());
    // Save pending payment
    DB::table('payments')->insert([
        'user_id'    => $user->id,
        'package'    => $orderId,
        'reference'  => $reference,
        'amount'     => $amount,
        'status'     => 'pending',
        'gateway'    => 'flutterwave',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // ✅ Create Flutterwave Payment
    $paymentResponse = self::createFlutterwavePayment($user, $amount, $reference);
    if (empty($paymentResponse['url'])) {
        return ['status' => false, 'message' => 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance'];
    }

    return $paymentResponse;
}


public static function flutterwaveCallback(Request $request)
{
    $status = $request->query('status');
    $tx_ref = $request->query('tx_ref');
    $transaction_id = $request->query('transaction_id');

    // Fetch the payment record
    $payment = DB::table('payments')->where('reference', $tx_ref)->first();

    if (!$payment) {
        return GeneralController::sendNotification(
            'home',
            'error',
            'Payment Not Found!',
            'We could not locate this payment reference.'
        );
    }

    // Proceed only if Flutterwave sent completed/successful status
    if (in_array($status, ['completed', 'successful'])) {
        $verify = self::verifyFlutterwavePayment($transaction_id);

        if ($verify['status']) {
            DB::table('payments')->where('reference', $tx_ref)->update([
                'status' => 'success',
                'updated_at' => now(),
            ]);

            // ✅ If this payment was for an order, update that order status
            if (!empty($payment->package)) {
                Order::where('order_number', $payment->package)->update(['status' => 'paid']);
            }

            return GeneralController::sendNotification(
                'home',
                'success',
                'Payment Successful!',
                'Your payment was verified successfully.'
            );
        }
    }

    // ❌ If failed or not verified
    DB::table('payments')->where('reference', $tx_ref)->update([
        'status' => 'failed',
        'updated_at' => now(),
    ]);

    return GeneralController::sendNotification(
        'home',
        'error',
        'Payment Failed!',
        'Your payment could not be verified.'
    );
}


private static function verifyFlutterwavePayment($transactionId)
{
    $flutterwaveSecret = "FLWSECK_TEST-8b272f9980fbdb0c8432798843b07dfe-X";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$transactionId/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $flutterwaveSecret"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);

    // Debug output for now
    // dd($result);

    if (!empty($result['status']) && $result['status'] === 'success' && $result['data']['status'] === 'successful') {
        return ['status' => true, 'data' => $result['data']];
    }

    return ['status' => false, 'message' => $result['message'] ?? 'Verification failed'];
}


private static function createFlutterwavePayment($user, $amount, $reference)
{
    $flutterwaveSecret = "FLWSECK_TEST-8b272f9980fbdb0c8432798843b07dfe-X"; // from .env
    $callbackUrl = route('package.callback');

    $payload = [
        "tx_ref" => $reference,
        "amount" => $amount,
        "currency" => "NGN",
        "redirect_url" => $callbackUrl,
        "customer" => [
            "email" => $user->email,
            "name" => $user->name,
        ],
        "customizations" => [
            "title" => "Product Payment",
        ],
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $flutterwaveSecret",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (!empty($result['status']) && $result['status'] === 'success') {
        return ['url' => $result['data']['link'], 'status' => true, 'message' => 'payment linked generated'];
    }

    return ['status' => false, 'message' => $result['message'] ?? 'Unknown error'];
}


    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders', compact('orders'));
    }

    public function show($order)
    {

        $order = Order::where('order_number', '=', $order)->first();
        return view('frontend.order_detail', compact('order'));
    }
    public function admin_order_show($order)
    {

        $order = Order::where('order_number', '=', $order)->first();
        return view('admin.orders_detail', compact('order'));
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


    public function delete_user_order($orderNumber)
    {
        $order = Order::where('id', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return GeneralController::sendNotification('', 'error', '', 'Only pending orders can be deleted.');
        }

        $order->delete();

        return GeneralController::sendNotification('', 'success', '', 'Order deleted successfully.');
    }

    public function admin_user_repayment($id)
    {
        $payments = Payment::where('user_id', $id)->where('package', 'loan_repayment')->get();
        $info = User::find($id);
        $full_name = $info->first_name . " " . $info->last_name;
        return view('admin.user_repayment', compact('payments', 'full_name'));
    }
}
