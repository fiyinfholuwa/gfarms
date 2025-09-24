<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Dojah\Client; // the correct SDK class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{

    protected $dojah;
    protected $baseUrl = "https://api.paystack.co";

    /**
     * Initialize Dojah SDK only when needed
     */
    private function getDojahClient(): Client
{
    if (!$this->dojah) {
        $this->dojah = new Client(
            Authorization: env('DOJAH_API_KEY'),
            AppId: env('DOJAH_APP_ID'),
        );
    }
    return $this->dojah;
}




public function launch(Request $request)
{
    $package = $request->get('package', 'basic');

    $widgetId = env(match ($package) {
        'medium'       => 'DOJAH_WIDGET_MEDIIUM',
        'market_woman' => 'DOJAH_WIDGET_BUSINESS',
        'high'         => 'DOJAH_WIDGET_HIGH',
        default        => 'DOJAH_WIDGET_BASIC',
    });

    $user = Auth::user();
    
    $reference = $user->id.'_'.\Illuminate\Support\Str::uuid();

    $user->update([
        'kyc_reference' => $reference,
        'kyc_status'    => 'pending',
    ]);

    return view('user.kyc_start', [
        'reference' => $reference,
        'widgetId'  => $widgetId,
        'appId'     => env('DOJAH_APP_ID'),
        'publicKey' => env('DOJAH_PUBLIC_KEY'),
        'user'      => $user
    ]);
}



public function handleWebhook(Request $request)
{
    try {
        // Parse payload safely
        $payload = $request->all();
        if (empty($payload)) {
            $payload = json_decode($request->getContent(), true);
        }

        Log::info('Dojah Webhook Payload:', [
            'raw' => $request->getContent(),
            'parsed' => $payload,
        ]);

        // Ensure Completed status
        if (($payload['verification_status'] ?? '') !== 'Completed') {
            return response()->json(['message' => 'Verification not completed'], 200);
        }

        // Extract reference
        $reference = $payload['metadata']['reference'] ?? null;
        if (!$reference) {
            return response()->json(['message' => 'Reference not found'], 400);
        }

        $user = User::where('kyc_reference', $reference)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update names
        $firstName = $payload['data']['government_data']['data']['bvn']['entity']['first_name'] ?? null;
        $lastName  = $payload['data']['government_data']['data']['bvn']['entity']['last_name'] ?? null;

        $user->first_name   = $firstName ?? $user->first_name;
        $user->last_name    = $lastName ?? $user->last_name;
        $user->kyc_response = json_encode($payload);
        $user->has_done_kyc = 'yes';
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    } catch (\Exception $e) {
        Log::error('Dojah Webhook Error: ' . $e->getMessage());
        return response()->json(['message' => 'Server error'], 500);
    }
}


public function complete()
{
    $user = Auth::user();

    if ($user->has_done_kyc === 'yes') {
        // ✅ KYC completed
        return GeneralController::sendNotification(
            'dashboard',
            'success',
            'Onboarding Complete!',
            'Your KYC completed successfully!'
        );    }

        return GeneralController::sendNotification(
            'dashboard',
            'info',
            'Onboarding In Progress!',
            'Your KYC verification was successful. Our System will Update your info Shortly'
        );

}


public function complete_old(Request $request)
{
    $user = Auth::user();
    $reference = $user->kyc_reference;

    $client = new \GuzzleHttp\Client([
        'headers' => [
            'Authorization' => env('DOJAH_API_KEY'),
            'AppId'         => env('DOJAH_APP_ID'),
        ]
    ]);

    $response = $client->get("https://sandbox.dojah.io/api/v1/kyc/verification?reference=$reference");
    dd($response);
    
    $data = json_decode($response->getBody(), true);

    $user->kyc_response = json_encode($data);
    $user->has_done_kyc = 'yes';
    $user->save();

    return GeneralController::sendNotification('dashboard', 'success', 'Onboarding Complete!', 'Your onboarding payment was successful. You can now complete KYC.');
}

// public function complete(Request $request)
// {
// // Debug everything coming in

//     $user = Auth::user();

//     // Dojah will usually return reference_id or verification_id in request
//     $verificationId = $request->get('verification_id'); 
//     $referenceId    = $request->get('reference_id');

//     if (!$verificationId && !$referenceId) {
//         return GeneralController::sendNotification('dashboard', 'error', 'Verification Failed', 'No verification_id or reference_id provided.');
//     }

//     $client = new \GuzzleHttp\Client([
//         'headers' => [
//             'Authorization' => env('DOJAH_API_KEY'),
//             'AppId'         => env('DOJAH_APP_ID'),
//         ]
//     ]);

//     $url = "https://sandbox.dojah.io/api/v1/kyc/verification?"
//          . ($verificationId ? "verification_id=$verificationId" : "reference_id=$referenceId");

//     $response = $client->get($url);
//     $data = json_decode($response->getBody(), true);

//     dd($response);
//     $user->update([
//         'kyc_response' => json_encode($data),
//         'has_done_kyc' => 'yes',
//     ]);

//     return GeneralController::sendNotification('dashboard', 'success', 'Onboarding Complete!', 'KYC verification successful.');
// }


    private static function get_base_url(){
        return 'https://sandboxapi.fincra.com';
    }
    public function showForm()
    {
        $packages = [
            'low' => ['name'=>'Low-Level Users','limit'=>'₦10k-₦50k','period'=>'30 days','options'=>['Weekly','Semi-Weekly','Bi-Weekly','Outright']],
            'mid' => ['name'=>'Mid-Level Users','limit'=>'₦51k-₦200k','period'=>'30 days','options'=>['Weekly','Semi-Weekly','Bi-Weekly','Outright']],
            'high'=> ['name'=>'High-Level Users','limit'=>'₦201k-₦500k+','period'=>'60 days','options'=>['Weekly','Semi-Weekly','Bi-Weekly','Monthly','Outright']],
            'market'=>['name'=>'Market Women & Traders','limit'=>'Flexible','period'=>'Daily/Weekly','options'=>['Daily','Weekly','Semi-Flexible']],
        ];
        return view('auth.package', compact('packages'));
    }

    private function createFincraPayment($user, $amount, $reference)
    {
        $redirectUrl = route('package.callback');
    
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => env('FINCRA_SECRET_KEY'),
            'x-business-id' => env('FINCRA_BUSINESS_ID'),
            'x-pub-key' => env('FINCRA_PUBLIC_KEY'),
            'content-type' => 'application/json'
        ])->post($this->get_base_url() . '/checkout/payments', [
            "currency"       => "NGN",
            "amount"         => $amount,
            "customer"       => [
                "name"  => $user->first_name . " ". $user->last_name,
                "email" => $user->email
            ],
            "paymentMethods" => ["bank_transfer"],
            "feeBearer"      => "customer",
            "redirectUrl"    => $redirectUrl,
            "reference"      => $reference,
        ])->json();
    
        return isset($response['data']['link'])
            ? ['url' => $response['data']['link']]
            : [];
    }
    

    private function createPaystackPayment($user, $amount, $reference)
{
    $redirectUrl = route('package.callback');

    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
        ->post('https://api.paystack.co/transaction/initialize', [
            "email"        => $user->email,
            "amount"       => $amount * 100,
            "reference"    => $reference,
            "callback_url" => $redirectUrl,
        ])->json();

    return (isset($response['status']) && $response['status'] === true)
        ? ['url' => $response['data']['authorization_url']]
        : [];
}


 

    public function startPayment(Request $request)
{
    $gateway = $request->query('gateway', 'fincra'); // Default gateway is Fincra
    $user = Auth::user();

    // Generate reference with gateway prefix
    $reference = strtoupper($gateway) . '_' . Str::uuid();
    $amount = 500;
    // Save pending payment
    DB::table('payments')->insert([
        'user_id'    => $user->id,
        'package'    => 'onboarding',
        'reference'  => $reference,
        'amount'     => $amount,
        'status'     => 'pending',
        'gateway'    => $gateway,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // ✅ Call the correct payment creation method
    $paymentResponse = ($gateway === 'paystack') 
        ? $this->createPaystackPayment($user,  $amount, $reference) 
        : $this->createFincraPayment($user, $amount, $reference);

    // ✅ Normalize the payment URL (both methods must return ['url' => '...'])
    if (empty($paymentResponse['url'])) {
        return GeneralController::sendNotification('', 'error', 'Onboarding Payment!', 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance');
    }

    // ✅ Redirect to gateway URL
    return redirect($paymentResponse['url']);
}


public function pay_processing_fee(Request $request)
{
    $gateway = $request->payment_type;
    $id = $request->order_id;
    $user = Auth::user();
    $amount = 1000;
    $reference = strtoupper($gateway) . '_' . Str::uuid();

    // Save pending payment
    DB::table('payments')->insert([
        'user_id'    => $user->id,
        'package'    => 'processing_fee|'.$id,
        'reference'  => $reference,
        'amount'     => $amount,
        'status'     => 'pending',
        'gateway'    => $gateway,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Call the correct payment creation method
    $paymentResponse = ($gateway === 'paystack') 
        ? $this->createPaystackPayment($user, $amount, $reference) 
        : $this->createFincraPayment($user, $amount, $reference);

    if (empty($paymentResponse['url'])) {
        return response()->json([
            'status'  => 'error',
            'title'   => 'Processing Fee Payment!',
            'message' => 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance',
        ], 500);
    }

    return response()->json([
        'status' => 'success',
        'url'    => $paymentResponse['url'],
        'reference' => $reference,
    ]);
}
public function pay_processing_fee_onspot(Request $request)
{
    $data = $request->all();   // grab all input from fetch()

    $gateway = $data['payment_type'];
    $id = $data['order_id'];
    $user = Auth::user();
    $amount = 1000;
    $reference = strtoupper($gateway) . '_' . Str::uuid();

    DB::table('payments')->insert([
        'user_id'    => $user->id,
        'package'    => 'processing_fee|' . $id,
        'reference'  => $reference,
        'amount'     => $amount,
        'status'     => 'pending',
        'gateway'    => $gateway,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $paymentResponse = ($gateway === 'paystack') 
        ? $this->createPaystackPayment($user, $amount, $reference) 
        : $this->createFincraPayment($user, $amount, $reference);

    if (empty($paymentResponse['url'])) {
        return response()->json([
            'status'  => 'error',
            'title'   => 'Processing Fee Payment!',
            'message' => 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance',
        ], 500);
    }

    return response()->json([
        'status'    => 'success',
        'url'       => $paymentResponse['url'],
        'reference' => $reference,
    ]);
}


    /**
     * ✅ Handle Fincra Payment Callback
     */
    private function verifyPaystackPayment($reference)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();

        if (isset($response['status']) && $response['status'] === true && $response['data']['status'] === 'success') {
            return ['status' => true];
        }
        return ['status' => false];
    }

    /**
     * ✅ Verify Fincra Payment
     */
    private function verifyFincraPayment($reference)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => env('FINCRA_SECRET_KEY'),
            'x-business-id' => env('FINCRA_BUSINESS_ID'),
            'x-pub-key' => env('FINCRA_PUBLIC_KEY'),
        ])->get($this->get_base_url() . '/checkout/payments/merchant-reference/' . $reference)
          ->json();
        if (isset($response['status']) && $response['status'] === true) {
            $status = strtolower($response['data']['status'] ?? '');
            return ['status' => ($status === 'success' || $status === 'pending')];
        }
        return ['status' => false];
    }

    /**
     * ✅ Callback for Both Paystack & Fincra
     */

     public static function checkProcessingFee($string)
    {
        if (strpos($string, 'processing_fee|') !== false) {
            $parts = explode('|', $string);

            // make sure there's a value after "|"
            if (isset($parts[1]) && is_numeric($parts[1])) {
                return [
                    'status' => true,
                    'id' => (int)$parts[1]
                ];
            }
        }

        return [
            'status' => false,
            'id' => null
        ];
    }

    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        $payment = DB::table('payments')->where('reference', $reference)->first();

        if (!$payment) {
            return GeneralController::sendNotification('', 'error', ' Online Payment!', 'Payment record not found.');
        }
        $check_package = self::checkProcessingFee($payment->package);


        // ✅ Determine which gateway to verify
        $verifyResponse = ($payment->gateway === 'paystack') 
            ? $this->verifyPaystackPayment($reference)
            : $this->verifyFincraPayment($reference);

        if ($verifyResponse['status']) {
            DB::table('payments')->where('reference', $reference)->update([
                'status'     => 'success',
                'updated_at' => now()
            ]);
            if($check_package['status']){
                Order::where('id', $check_package['id'])
                ->update(['has_paid_delivery_fee' => 'yes']);
                        }
            User::findOrFail($payment->user_id)->update(['has_paid_onboarding' => 'yes']);
            if($check_package['status']){
                return GeneralController::sendNotification('user.orders', 'success', 'Online  Payment!', 'Payment successful!');
            }else{
                return GeneralController::sendNotification('dashboard', 'success', 'Online  Payment!', 'Payment successful!');
            }
        } else {
            DB::table('payments')->where('reference', $reference)->update([
                'status'     => 'failed',
                'updated_at' => now()
            ]);
            if($check_package['status']){
                return GeneralController::sendNotification('user.orders', 'error', 'Online Payment!', 'Payment verification failed.');
            }else{
                return GeneralController::sendNotification('dashboard', 'error', 'Online Payment!', 'Payment verification failed.');
            }

        }
    }



    public function webhook(Request $request)
{
    $data = $request->all();

    $user =User::where('kyc_reference', $data['metadata']['reference'] ?? null)->first();

    if ($user) {
        $user->update([
            'kyc_status'   => $data['status'] ?? 'failed',
            'kyc_response' => json_encode($data),
        ]);
    }

    return response()->json(['success' => true]);
}



public function payment_user(Request $request)
    {
        $user = Auth::user();
        
        // Base query for user's payments
        $query = Payment::where('user_id', $user->id);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }
        
        if ($request->filled('package')) {
            $query->where('package', $request->package);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }
        
        // Get payments with pagination
        $payments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Calculate statistics
        $allUserPayments = Payment::where('user_id', $user->id);
        $totalAmount = $allUserPayments->where('status', 'success')->sum('amount');
        $totalPayments = $allUserPayments->count();
        $successfulPayments = $allUserPayments->where('status', 'success')->count();
        
        return view('user_new.transaction', compact(
            'payments', 
            'totalAmount', 
            'totalPayments', 
            'successfulPayments'
        ));
    }



    public function generateVirtualAccountForUser($email, $firstName, $lastName, $phone, $bank = "wema-bank")
    {
        // Step 1: Create customer (if already exists, Paystack will return it)
        $customerResponse = $this->makeRequest("POST", $this->baseUrl . "/customer", [
            "email" => $email,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "phone" => $phone
        ]);
        if (!$customerResponse['status']) {
            return [
                "status" => false,
                "message" => "Failed to create/fetch customer on Paystack",
                "error" => $customerResponse
            ];
        }

        $customerId = $customerResponse['data']['id']; // numeric ID

        // Step 2: Create dedicated account
        $accountResponse = $this->makeRequest("POST", $this->baseUrl . "/dedicated_account", [
            "customer" => $customerId,
            "preferred_bank" => 'test-bank'
        ]);
        return $accountResponse;
    }

    private function makeRequest($method, $url, $data = [])
    {
        $client = new \GuzzleHttp\Client();

        $options = [
            "headers" => [
                "Authorization" => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                "Accept" => "application/json"
            ]
        ];

        if (!empty($data)) {
            $options["json"] = $data;
        }

        $response = $client->request($method, $url, $options);

        return json_decode($response->getBody(), true);
    }

    public function generate_virtual_account()
{
    $email = Auth::user()->email;
    $first_name = Auth::user()->first_name;
    $last_name = Auth::user()->last_name;
    $phone = Auth::user()->phone;

    $account = $this->generateVirtualAccountForUser(
        $email,
        $first_name,
        $last_name,
        $phone
    );

    if (!empty($account['status']) && $account['status'] === true) {
        $user = User::findOrFail(Auth::id());

        // save only account_name + account_number + bank name as JSON
        $user->virtual_account_number = json_encode([
            'account_name'   => $account['data']['account_name'] ?? null,
            'account_number' => $account['data']['account_number'] ?? null,
            'bank'           => $account['data']['bank'] ?? null,
        ]);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Account generated successfully',
            'data' => $user->virtual_account_number
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => $account['message'] ?? 'Failed to generate account'
    ]);
}


}



?>