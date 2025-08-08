<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;





Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/check/login', [AuthController::class, 'check_login'])->name('check_login');


Route::get('/locations/states', [RegisteredUserController::class, 'getStates']);
Route::get('/locations/lgas/{state}', [RegisteredUserController::class, 'getLgas']);
Route::get('/verify-otp', [AuthController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verify'])->name('otp.verify.submit');
Route::post('/resend-otp', [AuthController::class, 'resend'])->name('otp.resend');




// ✅ User Dashboard
Route::middleware(['auth', 'onboard_kyc'])->group(function () {

    // Dashboard

    // Profile
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('user.profile');

    // Credit & Eligibility
    Route::get('/credit', [UserDashboardController::class, 'credit'])->name('user.credit');

    // Apply for Foodstuff Plan
    Route::get('/apply-plan', [UserDashboardController::class, 'apply'])->name('user.apply.plan');

    // Foodstuff Packages
    Route::get('/packages', [UserDashboardController::class, 'browse'])->name('user.packages');
    Route::get('/my-packages', [UserDashboardController::class, 'myPackages'])->name('user.my.packages');

    // Repayment
    Route::get('/repayments/schedule', [UserDashboardController::class, 'schedule'])->name('user.repayments.schedule');
    Route::get('/repayments/history', [UserDashboardController::class, 'history'])->name('user.repayments.history');

    // Delivery Status
    Route::get('/delivery-status', [UserDashboardController::class, 'deliveryStatus'])->name('user.delivery.status');

    // Notifications
    Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');

    // Support
    Route::get('/support', [UserDashboardController::class, 'index'])->name('user.support');

    // Logout
    Route::get('/logout', [UserDashboardController::class, 'logout'])->name('logout');
    
});




Route::get('/pay/onboarding', [PackageController::class, 'startPayment'])->name('pay.onboarding');
Route::get('/payment/callback', [PackageController::class, 'paymentCallback'])->name('package.callback');

Route::post('/kyc/webhook', [PackageController::class, 'webhook'])->name('kyc.webhook');

Route::post('/kyc/process/{level}', [PackageController::class, 'launch'])->name('kyc.process');
Route::match(['get', 'post'], '/kyc/complete', [PackageController::class, 'complete'])->name('kyc.complete');

Route::get('/select-package', [PackageController::class, 'showForm'])->name('package.form');

Route::post('/payment/webhook', [PackageController::class, 'webhook'])->name('package.webhook');



Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/foods/create', [AdminController::class, 'product_view'])->name('admin.product.add');
    Route::post('/foods/store', [AdminController::class, 'product_store'])->name('foods.store');
    Route::post('/foods/update/{id}', [AdminController::class, 'product_update'])->name('foods.update');
    Route::get('/foods/edit/{id}', [AdminController::class, 'product_edit'])->name('foods.edit');
    Route::delete('/foods/delete/{id}', [AdminController::class, 'product_delete'])->name('foods.destroy');
    Route::get('/foods/all', [AdminController::class, 'product_all'])->name('foods.all');
});


Route::middleware(['auth'])->group(function () {

    // Dashboard

    // Profile


    // Apply for Foodstuff Plan
    Route::get('/admin/product/add', [AdminController::class, 'product_view'])->name('admin.product.add');

    
    // Foodstuff Packages
    Route::get('/packages', [UserDashboardController::class, 'browse'])->name('user.packages');
    Route::get('/my-packages', [UserDashboardController::class, 'myPackages'])->name('user.my.packages');

    // Repayment
    Route::get('/repayments/schedule', [UserDashboardController::class, 'schedule'])->name('user.repayments.schedule');
    Route::get('/repayments/history', [UserDashboardController::class, 'history'])->name('user.repayments.history');

    // Delivery Status
    Route::get('/delivery-status', [UserDashboardController::class, 'deliveryStatus'])->name('user.delivery.status');

    // Notifications
    Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');

    // Support
    Route::get('/support', [UserDashboardController::class, 'index'])->name('user.support');

    // Logout
    Route::get('/logout', [UserDashboardController::class, 'logout'])->name('logout');
    
});

require __DIR__.'/auth.php';
