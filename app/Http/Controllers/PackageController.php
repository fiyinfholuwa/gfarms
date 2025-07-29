<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PackageController extends Controller
{
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
    ])->post('https://sandboxapi.fincra.com/checkout/payments', [
        "currency"       => "NGN",
        "amount"         => 500,
        "customer"       => [
            "name"  => $user->name,
            "email" => $user->email
        ],
        "paymentMethods" => ["card", "bank_transfer"],
        "feeBearer"      => "business",
        "redirectUrl"    => $redirectUrl,
        "reference"      => $reference, // ✅ Send as field also
    ]);

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
        $request->validate([
            'package' => 'required|string',
            'id_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Upload ID card
        $filename = time() . '_' . $request->file('id_card')->getClientOriginalName();
        $path = public_path('uploads/id_cards');
        if (!file_exists($path)) mkdir($path, 0755, true);
        $request->file('id_card')->move($path, $filename);

        // Store initial payment record
        $reference = 'FINCRA_' . Str::uuid();
        $user = Auth::user();

        DB::table('payments')->insert([
            'user_id' => $user->id,
            'package' => $request->package,
            'reference' => $reference,
            'amount' => 50000,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Call reusable method to create Fincra payment
        $paymentResponse = $this->createFincraPayment($user, $reference);

        if (empty($paymentResponse['data']['link'])) {
            return back()->with('error', 'Payment link could not be generated.');
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
}

?>