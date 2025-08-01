<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.email_verification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|numeric',
        ]);

        $email = Auth::user()->email;
        $enteredOtp = implode('', $request->otp);

        if (Cache::get('otp_' . $email) == $enteredOtp) {
            Cache::forget('otp_' . $email);
            User::findOrFail(Auth::user()->id)->update(['has_verified_email' => 'yes']);
            return redirect()->route('check_login')->with('success', 'OTP verified successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP']);
    }

    public function resend()
    {
        $email = Auth::user()->email;
        $otp = rand(100000, 999999);

        // ✅ Store new OTP in cache
        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        // ✅ Send OTP directly from here
        Mail::raw("Your new OTP code is: {$otp}\n\nIt expires in 10 minutes.", function ($message) use ($email) {
            $message->to($email)->subject('Your New Aurelious OTP Code');
        });

        return back()->with('status', 'A new OTP has been sent to your email.');
    }

    public function check_login(){
        if (Auth::id()) {
            if (Auth::user()->has_verified_email=='no') {
                return redirect()->route('otp.verify');
            }elseif(Auth::user()->has_paid_onboarding=='yes'){
                return redirect()->route('dashboard');
             }
            else{
                return redirect()->route('login');
            }
        }else{
            return redirect()->back();
        }
    }
}
