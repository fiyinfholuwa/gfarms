<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        
        return view('auth_new.register');
        }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:20'],
        'state' => ['required', 'string'],
        'lga' => ['required', 'string'],
        'country' => ['required', 'string'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'terms' => ['accepted'],
        'employee_status' => 'required|in:Employed,Non Student/ Non Employed,Trader,Student',
        'student_id' => 'required_if:employee_status,Student|string|nullable|max:255',
        'school_name' => 'required_if:employee_status,Student|string|nullable|max:255',

    ]);

    // ✅ Create user
    $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'state' => $request->state,
        'lga' => $request->lga,
        'country' => $request->country,
        'employee_status' => $request->employee_status,
        'student_id' => $request->student_id,
        'school_name' => $request->school_name,
        'password' => Hash::make($request->password),
    ]);

    // ✅ Fire registered event
    event(new Registered($user));

    // ✅ Generate OTP and store in cache (valid for 10 minutes)
    $otp = rand(100000, 999999);
    Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10));

    // ✅ Send OTP email directly here
    Mail::raw("Your Aurelious OTP Code is: {$otp}\n\nThis code expires in 10 minutes.", function($message) use ($user) {
        $message->to($user->email)
                ->subject('Your Aurelious OTP Code');
    });

    // ✅ Login user
    Auth::login($user);

    return redirect()->route('otp.verify')->with('status', 'Registration successful! Check your email for OTP.');
}

    public function getStates()
    {
        $response = Http::get('https://api.facts.ng/v1/states');
        return $response->json(); // return states to frontend
    }

    public function getLgas($state)
    {
        $state = urlencode($state);
        $response = Http::get("https://api.facts.ng/v1/states/{$state}");
        return $response->json(); // return LGAs to frontend
    }

    

}
