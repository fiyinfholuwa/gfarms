<?php

namespace App\Http\Middleware;

use App\Http\Controllers\GeneralController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKycOnboarding
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Get the authenticated user
        $user = $request->user();

        // If there is no logged-in user, just proceed
        if (!$user) {
            return $next($request);
        }

        // ✅ Check if the user has not paid onboarding
        if ($user->has_paid_onboarding === 'no') {
            return GeneralController::sendNotification(
                null, 
                'error', 
                'Onboarding Payment Required', 
                'You must complete your onboarding payment before you can access this section.'
            );
        }

        // ✅ Check if the user has not completed KYC
        if ($user->has_done_kyc === 'no') {
            return GeneralController::sendNotification(
                null, 
                'error', 
                'KYC Verification Required', 
                'You must complete your KYC verification before you can access this section.'
            );
        }

        // ✅ If both checks pass, allow request to continue
        return $next($request);
    }
}
