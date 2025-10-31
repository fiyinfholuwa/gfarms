<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $settings = PlatformSetting::first();

        return view('auth_new.register', compact('settings'));
        }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */


     public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

       
        // Create user
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10));

        Mail::raw("Your GINELLA OTP Code is: {$otp}\n\nThis code expires in 10 minutes.", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your GINELLA OTP Code');
        });

        Auth::login($user);

        // ✅ Respond with JSON if AJAX
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('otp.verify'),
                'message' => 'Registration successful! Check your email for OTP.'
            ]);
        }

        return redirect()->route('otp.verify')->with('status', 'Registration successful! Check your email for OTP.');

    } catch (ValidationException $e) {
        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }
        throw $e;
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}
    
public function store_old(Request $request): RedirectResponse
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
        'employee_status' => 'required',
        'student_id' => 'nullable|required_if:employee_status,Student|mimes:jpg,jpeg,png,pdf|max:2048',
        'school_name' => 'required_if:employee_status,Student|string|nullable|max:255',

    ]);

    $studentIdPath = null;
if ($request->hasFile('student_id')) {
    $file = $request->file('student_id');
    $studentIdPath = 'uploads/student_ids/';
    if (!file_exists(public_path($studentIdPath))) {
        mkdir(public_path($studentIdPath), 0755, true);
    }
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path($studentIdPath), $filename);
    $studentIdPath .= $filename;
}


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
        'student_id' => $studentIdPath, // 👈 now it stores the file path
        'school_name' => $request->school_name,
        'password' => Hash::make($request->password),
    ]);

    // ✅ Fire registered event
    event(new Registered($user));

    // ✅ Generate OTP and store in cache (valid for 10 minutes)
    $otp = rand(100000, 999999);
    Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10));

    // ✅ Send OTP email directly here
    Mail::raw("Your GINELLA OTP Code is: {$otp}\n\nThis code expires in 10 minutes.", function($message) use ($user) {
        $message->to($user->email)
                ->subject('Your GINELLA OTP Code');
    });

    // ✅ Login user
    Auth::login($user);

    return redirect()->route('otp.verify')->with('status', 'Registration successful! Check your email for OTP.');
}

public function getStates()
{
    $response = Http::get('https://api.facts.ng/v1/states');
    $states = $response->json();

    // Append FCT in same format
    $states[] = [
        'id' => 'fct',   // this matches your frontend "value"
        'name' => 'Federal Capital Territory (Abuja)',
    ];

    return $states;
}

public function getLgas($state)
{
    $state = strtolower(trim($state));

    // Handle FCT manually
    if ($state === 'fct') {
        return [
            'lgas' => [
                'Abaji',
                'Abuja Municipal Area Council',
                'Bwari',
                'Gwagwalada',
                'Kuje',
                'Kwali'
            ]
        ];
    }

    // Default: fetch from API
    $state = urlencode($state);
    $response = Http::get("https://api.facts.ng/v1/states/{$state}");
    return $response->json();
}

    

}
