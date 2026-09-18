<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanNonPOController;
use App\Http\Controllers\LaporanPOController;
// Tracking invoice controller removed
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorPartnershipController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LoginBackgroundController;
use App\Http\Controllers\HeaderSearchController;
use App\Http\Controllers\ChecksheetMasterController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('login', function() {
  return view('auth.login');
})->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

// Logout Route
Route::post('logout', function() {
  auth()->logout();
  session()->invalidate();
  session()->regenerateToken();
  return redirect()->route('login');
})->name('logout');

// Admin Route - Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/export-monthly', [DashboardController::class, 'exportMonthly'])->name('dashboard.export-monthly');

// View Profile Route
Route::get('view-profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('view-profile', [ProfileController::class, 'update'])->name('profile.update');

// Duplicate profile page for visual QA
Route::get('profile-duplicate', function() {
    $user = auth()->user();
    return view('admin.profile-duplicate', compact('user'));
})->middleware('auth')->name('profile.duplicate');

// Admin Routes - Requires ADMIN or SUPER_ADMIN role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('header-search', HeaderSearchController::class)->name('header-search');
    Route::resource('checksheet-masters', ChecksheetMasterController::class)->except(['show']);

    // Purchase Order Routes
    Route::resource('kelola-po', 'App\Http\Controllers\PurchaseOrderController')->except(['show']);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::post('purchase-orders/{purchase_order}/close', [PurchaseOrderController::class, 'close'])
        ->name('purchase-orders.close');

    // Invoice Routes
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create-po', [InvoiceController::class, 'createPO'])->name('create-po');
        Route::post('/store-po', [InvoiceController::class, 'storePO'])->name('store-po');
        Route::get('/create-bisnis-internal', [InvoiceController::class, 'createBisnisInternal'])->name('create-bisnis-internal');
        Route::post('/store-bisnis-internal', [InvoiceController::class, 'storeBisnisInternal'])->name('store-bisnis-internal');
        Route::get('/create-vending', [InvoiceController::class, 'createVending'])->name('create-vending');
        Route::post('/store-vending', [InvoiceController::class, 'storeVending'])->name('store-vending');
        Route::get('/create-pulsa-modem', [InvoiceController::class, 'createPulsaModem'])->name('create-pulsa-modem');
        Route::post('/store-pulsa-modem', [InvoiceController::class, 'storePulsaModem'])->name('store-pulsa-modem');
        Route::get('/create-voucher', [InvoiceController::class, 'createVoucher'])->name('create-voucher');
        Route::post('/store-voucher', [InvoiceController::class, 'storeVoucher'])->name('store-voucher');
        Route::get('/create-non-po', [InvoiceController::class, 'createNonPO'])->name('create-non-po');
        Route::get('/create-sementara', [InvoiceController::class, 'createSementara'])->name('create-sementara');
        Route::post('/store-sementara', [InvoiceController::class, 'storeSementara'])->name('store-sementara');
        Route::post('/store-non-po', [InvoiceController::class, 'storeNonPO'])->name('store-non-po');
        Route::post('/export', [InvoiceController::class, 'export'])->name('export');
        Route::get('/create-pascabayar', [InvoiceController::class, 'createPascabayar'])->name('create-pascabayar');
        Route::post('/store-pascabayar', [InvoiceController::class, 'storePascabayar'])->name('store-pascabayar');
        Route::post('/update-pascabayar-options', [InvoiceController::class, 'updatePascabayarItemOptions'])->name('update-pascabayar-options');
        Route::get('/non-po/{invoice}', [InvoiceController::class, 'showNonPO'])->name('show-non-po');
        Route::get('/pascabayar/{invoice}', [InvoiceController::class, 'showPascabayar'])->name('show-pascabayar');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
    });

    Route::get('invoice-non-po/{invoice}', [InvoiceController::class, 'showNonPO'])->name('invoice-non-po.show');
    Route::get('invoice-pascabayar/{invoice}', [InvoiceController::class, 'showPascabayar'])->name('invoice-pascabayar.show');
    Route::get('invoice-po/{invoice}', [InvoiceController::class, 'showPO'])->name('invoice-po.show');

    // Laporan Routes
    Route::get('laporan/non-po', [LaporanNonPOController::class, 'index'])->name('laporan.non-po');
    Route::get('laporan/rekap-po', [LaporanPOController::class, 'rekapPO'])->name('laporan.rekap-po');
    // Tracking invoice routes removed

    // Vendor Partnership (Open Table only)
    Route::get('vendors', [VendorPartnershipController::class, 'index'])->name('vendors.index');
    Route::post('vendors/open-table', [VendorPartnershipController::class, 'storeOpenTable'])->name('vendors.open-table.store');

    Route::get('reminders', [ReminderController::class, 'index'])->name('reminders.index');

});

// Super Admin Routes - Requires SUPER_ADMIN role
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Login background settings (SUPER_ADMIN only)
    Route::get('settings/login-background', [LoginBackgroundController::class, 'index'])->name('settings.login_background.index');
    Route::post('settings/login-background', [LoginBackgroundController::class, 'store'])->name('settings.login_background.store');
    Route::post('settings/login-background/{loginBackground}/activate', [LoginBackgroundController::class, 'activate'])->name('settings.login_background.activate');
    Route::delete('settings/login-background/{loginBackground}', [LoginBackgroundController::class, 'destroy'])->name('settings.login_background.destroy');
});


