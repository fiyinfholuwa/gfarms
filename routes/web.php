<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\UserDashboardController;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;













Route::get('/', function () {
    return view('auth_new.login');
});

Route::get('/dashboard', function () {
    $recent_orders = Order::where('user_id', Auth::id())->paginate(5);
    $foods = Food::paginate(5);
    return view('user_new.dashboard', compact('foods'));
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


    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::post('/support/store', [SupportTicketController::class, 'store'])->name('support.store');
    Route::post('/support/update/{id}', [SupportTicketController::class, 'update'])->name('support.update');
    Route::post('/support/delete/{id}', [SupportTicketController::class, 'destroy'])->name('support.delete');

    // Profile
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('user.profile');

    // Credit & Eligibility
    Route::get('/credit', [UserDashboardController::class, 'credit'])->name('user.credit');

    // Apply for Foodstuff Plan
    Route::get('/apply-plan', [UserDashboardController::class, 'apply'])->name('user.apply.plan');

    // Foodstuff Packages
    Route::get('/shop', [UserDashboardController::class, 'browse'])->name('user.packages');
    Route::get('/shop/detail/{name}', [UserDashboardController::class, 'shop_detail'])->name('shop.detail');
    Route::get('/categories', [UserDashboardController::class, 'category'])->name('category');
    Route::get('/food/category/{name}', [UserDashboardController::class, 'food_category'])->name('food.category');
    Route::get('/my-packages', [UserDashboardController::class, 'myPackages'])->name('user.my.packages');

    Route::get('/search-food', [UserDashboardController::class, 'search_food'])->name('food.search');

    // Repayment
    Route::get('/repayments/schedule', [UserDashboardController::class, 'schedule'])->name('user.repayments.schedule');
    Route::get('/repayments/history', [UserDashboardController::class, 'history'])->name('user.repayments.history');

    // Delivery Status
    Route::get('/delivery-status', [UserDashboardController::class, 'deliveryStatus'])->name('user.delivery.status');

    // Notifications
    Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');

    // Support
    Route::get('/cart', [UserDashboardController::class, 'my_cart'])->name('cart');

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

    Route::get('/orders', [AdminController::class, 'admin_orders'])->name('admin.orders');

    Route::post('/orders/update-status', [AdminController::class, 'updateStatus'])
        ->name('admin.update.order');

    Route::get('/orders/{order}', [AdminController::class, 'admin_order_show'])->name('admin.order.show');

    Route::get('/payment', [AdminController::class, 'payment_admin'])->name('admin.payment');

    Route::get('/support', [SupportTicketController::class, 'admin_support'])->name('admin.support');
    Route::post('/support/update-status/{id}', [SupportTicketController::class, 'updateStatus'])->name('support.updateStatus');


    Route::get('/kyc-levels', [AdminController::class, 'kyc_level'])->name('manage.account.level');
    Route::get('/manage/user/', [AdminController::class, 'manage_user'])->name('manage.user');
    Route::post('/kyc-levels/{key}/update', [AdminController::class, 'update_kyc_level'])->name('admin.kyc.update');

});


Route::middleware(['auth'])->group(function () {

    // Dashboard

    // Profile


    Route::get('/admin/category/manage', [AdminController::class, 'category_view'])->name('category.view');
    Route::post('/admin/category/add', [AdminController::class, 'category_add'])->name('category.add');
    Route::post('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('category.delete');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('category.edit');
    Route::post('/admin/category/update/{id}', [AdminController::class, 'category_update'])->name('category.update');

    // Apply for Foodstuff Plan
    Route::get('/admin/product/add', [AdminController::class, 'product_view'])->name('admin.product.add');
    Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');


    // Foodstuff Packages
    Route::get('/my-packages', [UserDashboardController::class, 'myPackages'])->name('user.my.packages');

    // Repayment
    Route::get('/repayments/schedule', [UserDashboardController::class, 'schedule'])->name('user.repayments.schedule');
    Route::get('/repayments/history', [UserDashboardController::class, 'history'])->name('user.repayments.history');

    // Delivery Status
    Route::get('/delivery-status', [UserDashboardController::class, 'deliveryStatus'])->name('user.delivery.status');

    // Notifications
    Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');

    // Support

    // Logout
    Route::get('/logout', [UserDashboardController::class, 'logout'])->name('logout');

    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('user.orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');

    // Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart', [CartController::class, 'destroy']);

    Route::post('/cart/update', [CartController::class, 'update_cart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove_from_cart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');

    // Order API routes
    Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders/processing/payment', [PackageController::class, 'pay_processing_fee'])->name('order.processing');
    Route::get('/generate/virtual/account/', [PackageController::class, 'generate_virtual_account'])->name('generate_virtual_account');

    // Assuming you have a food market route
    Route::get('/food-market', 'YourFoodMarketController@index')->name('food-market');
});

Route::post('/paystack/webhook', [PaymentWebhookController::class, 'handleWebhook']);


require __DIR__ . '/auth.php';
