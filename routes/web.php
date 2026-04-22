<?php
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryCrgController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// });

Auth::routes();

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/contact.page', [PageController::class, 'contact'])->name('contact.page');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');

Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');

Route::get('/stripe/{order}', [StripeController::class, 'index'])->name('stripe');
Route::post('/stripe', [StripeController::class, 'store'])->name('stripe.payment');




Route::POST('order-store', [CartController::class, 'checkout'])->name('orderStore');    



Route::post('/cart/add', [CartController::class, 'cartadd'])->name('cartadd');
Route::post('/cart/update/{rowId}', [CartController::class, 'cartupdate'])->name('cartupdate');
Route::get('/cart/destroy/{rowId}', [CartController::class, 'cartdestroy'])->name('cartdestroy');






Route::middleware(['auth','role:admin,maneger'])->group(function(){
Route::get('/admin', [PageController::class, 'dashboard'])->name('dashboard');
Route::resource('products', ProductController::class);
Route::resource('category', CategoryController::class);  
Route::resource('order', OrderController::class);  
Route::resource('contact', ContactController::class); 
Route::resource('deliveryCrg', DeliveryCrgController::class);  
Route::resource('coupon', CouponController::class);  


});



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
