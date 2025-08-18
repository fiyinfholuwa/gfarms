<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;









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

    // routes/web.php or routes/api.php
    Route::get('/cart/count', function () {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $items = $cart->items;
    
        $count = count($items);
            return response()->json(['count' => $count]);
    });
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
    Route::get('/user/payment', [PackageController::class, 'payment_user'])->name('user.payment');

});




Route::get('/pay/onboarding', [PackageController::class, 'startPayment'])->name('pay.onboarding');
Route::get('/payment/callback', [PackageController::class, 'paymentCallback'])->name('package.callback');

Route::post('/kyc/webhook', [PackageController::class, 'webhook'])->name('kyc.webhook');

Route::post('/kyc/process/{level}', [PackageController::class, 'launch'])->name('kyc.process');
Route::match(['get', 'post'], '/kyc/complete', [PackageController::class, 'complete'])->name('kyc.complete');

Route::get('/select-package', [PackageController::class, 'showForm'])->name('package.form');

Route::post('/payment/webhook', [PackageController::class, 'webhook'])->name('package.webhook');

Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add_cart'])->name('cart.add');



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


    Route::get('/admin/category/manage',[AdminController::class, 'category_view'])->name('category.view');
    Route::post('/admin/category/add', [AdminController::class, 'category_add'])->name('category.add');
    Route::post('/admin/category/delete/{id}',[AdminController::class, 'category_delete'])->name('category.delete');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('category.edit');
    Route::post('/admin/category/update/{id}',[AdminController::class, 'category_update'])->name('category.update');

    // Apply for Foodstuff Plan
    Route::get('/admin/product/add', [AdminController::class, 'product_view'])->name('admin.product.add');
    Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');

    
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
    
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('user.orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart', [CartController::class, 'destroy']);
    
    // Order API routes
    Route::post('/orders/checkout', [OrderController::class, 'checkout']);
    
    // Assuming you have a food market route
    Route::get('/food-market', 'YourFoodMarketController@index')->name('food-market');
});

require __DIR__.'/auth.php';
