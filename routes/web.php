<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use Illuminate\Support\Facades\Route;

// ==================== HALAMAN PUBLIK ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

require __DIR__.'/auth.php';

// ==================== NOTIFIKASI MIDTRANS (Wajib di Luar Auth) ====================
Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.notification');

// ==================== USER AREA ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return redirect()->route('home'); })->name('dashboard');

    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // JALUR SUKSES ANTI-GAGAL
    Route::get('/checkout/success-local/{order_number}', [CheckoutController::class, 'successLocal'])->name('checkout.successLocal');
    Route::get('/orders/{order_number}/snap-token', [CheckoutController::class, 'getSnapToken'])->name('orders.snapToken');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/show/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/mark-paid-cod/{id}', [OrderController::class, 'markPaidCod'])->name('orders.mark_paid_cod');
});

// ==================== ADMIN PANEL ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/preview-site', [DashboardController::class, 'previewSite'])->name('preview-site');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.payment-status');
    Route::post('/orders/{order}/confirm-cod', [AdminOrderController::class, 'confirmCod'])->name('orders.confirm_cod');
    Route::resource('users', AdminUserController::class);
    
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [AdminReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/excel', [AdminReportController::class, 'exportExcel'])->name('reports.sales.excel');
    Route::post('/reports/sales/clear', [AdminReportController::class, 'clearData'])->name('reports.sales.clear');
    Route::get('/reports/stock', [AdminReportController::class, 'stock'])->name('reports.stock');
});