<?php
namespace App\Http\Controllers;

use App\Models\User;
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
        'medium'    => 'DOJAH_WIDGET_MEDIIUM',
        'market_woman'   => 'DOJAH_WIDGET_BUSINESS',
        'high' => 'DOJAH_WIDGET_HIGH',
        default      => 'DOJAH_WIDGET_BASIC',
    });
    $user = auth()->user();
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


    return redirect()->away($url);
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
    ])->post($this->get_base_url() .'/checkout/payments', [
        "currency"       => "NGN",
        "amount"         => 1500,
        "customer"       => [
            "name"  => $user->first_name . " ". $user->last_name,
            "email" => $user->email
        ],
        "paymentMethods" => ["card", "bank_transfer"],
        "feeBearer"      => "customer",
        "redirectUrl"    => $redirectUrl,
        "reference"      => $reference, // ✅ Send as field also
    ]);

    // if ($response->failed()) {
    //     dd('Fincra Payment Creation Failed', ['body' => $response->body()]);
    // }


    return $response->json();
}


    /**
     * ✅ Verify Payment from Fincra
     */
    private function verifyFincraPayment($reference)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => env('FINCRA_SECRET_KEY'),
            'x-business-id' => env('FINCRA_BUSINESS_ID')
        ])->get($this->get_base_url() . "/checkout/payments/merchant-reference/{$reference}");

        return $response->json();
    }

    
    /**
     * ✅ Start Payment Process
     */
    public function startPayment(Request $request)
    {
    
        // Store initial payment record
        $reference = 'FINCRA_' . Str::uuid();
        $user = Auth::user();

        DB::table('payments')->insert([
            'user_id' => $user->id,
            'package' => 'onboarding',
            'reference' => $reference,
            'amount' => 1500,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Call reusable method to create Fincra payment
        $paymentResponse = $this->createFincraPayment($user, $reference);
        if (empty($paymentResponse['data']['link'])) {
            return GeneralController::sendNotification('', 'error', 'Onboarding Payment!', 'Payment Service is Down,Kindly Try Again Later or Reach out to Admin for Assistance');
        }

        return redirect($paymentResponse['data']['link']);
    }

    /**
     * ✅ Handle Fincra Payment Callback
     */
    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        $payment = DB::table('payments')->where('reference', $reference)->first();
        if (!$payment) {
            return redirect()->route('package.form')->with('error', 'Payment not found.');
        }

        // Verify with reusable method
        $verifyResponse = $this->verifyFincraPayment($reference);

        if (!empty($verifyResponse['status']) && $verifyResponse['status'] === true) {
            DB::table('payments')->where('reference', $reference)->update([
                'status' => 'success',
                'updated_at' => now()
            ]);
            User::findOrFail($payment->user_id)->update(['has_paid_onboarding' => 'yes']);
            return redirect()->route('dashboard')->with('success', 'Payment successful, package activated!');
        } else {
            DB::table('payments')->where('reference', $reference)->update([
                'status' => 'failed',
                'updated_at' => now()
            ]);
            return redirect()->route('package.form')->with('error', 'Payment verification failed.');
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

}

?>