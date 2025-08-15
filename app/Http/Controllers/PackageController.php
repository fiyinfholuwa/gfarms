<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Dojah\Client; // the correct SDK class


class PackageController extends Controller
{

    protected $dojah;

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






public function complete(Request $request)
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
    $data = json_decode($response->getBody(), true);

    $user->kyc_response = json_encode($data);
    $user->has_done_kyc = 'yes';
    $user->save();

    return GeneralController::sendNotification('dashboard', 'success', 'Onboarding Complete!', 'Your onboarding payment was successful. You can now complete KYC.');
}


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

    private function createFincraPayment($user, $reference)
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
            "amount"         => 500,
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
    

    private function createPaystackPayment($user, $reference)
{
    $redirectUrl = route('package.callback');

    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
        ->post('https://api.paystack.co/transaction/initialize', [
            "email"        => $user->email,
            "amount"       => 500 * 100,
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

    // Save pending payment
    DB::table('payments')->insert([
        'user_id'    => $user->id,
        'package'    => 'onboarding',
        'reference'  => $reference,
        'amount'     => 1500,
        'status'     => 'pending',
        'gateway'    => $gateway,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // ✅ Call the correct payment creation method
    $paymentResponse = ($gateway === 'paystack') 
        ? $this->createPaystackPayment($user, $reference) 
        : $this->createFincraPayment($user, $reference);

    // ✅ Normalize the payment URL (both methods must return ['url' => '...'])
    if (empty($paymentResponse['url'])) {
        return GeneralController::sendNotification('', 'error', 'Onboarding Payment!', 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance');
    }

    // ✅ Redirect to gateway URL
    return redirect($paymentResponse['url']);
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
    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        $payment = DB::table('payments')->where('reference', $reference)->first();

        if (!$payment) {
            return GeneralController::sendNotification('', 'error', 'Onboarding Payment!', 'Payment record not found.');
        }

        // ✅ Determine which gateway to verify
        $verifyResponse = ($payment->gateway === 'paystack') 
            ? $this->verifyPaystackPayment($reference)
            : $this->verifyFincraPayment($reference);

        if ($verifyResponse['status']) {
            DB::table('payments')->where('reference', $reference)->update([
                'status'     => 'success',
                'updated_at' => now()
            ]);
            User::findOrFail($payment->user_id)->update(['has_paid_onboarding' => 'yes']);
            return GeneralController::sendNotification('dashboard', 'success', 'Onboarding Payment!', 'Payment successful!');
        } else {
            DB::table('payments')->where('reference', $reference)->update([
                'status'     => 'failed',
                'updated_at' => now()
            ]);
            return GeneralController::sendNotification('dashboard', 'error', 'Onboarding Payment!', 'Payment verification failed.');
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
        
        return view('user.payment', compact(
            'payments', 
            'totalAmount', 
            'totalPayments', 
            'successfulPayments'
        ));
    }

}

?>