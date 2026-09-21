<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ==============================
// Autentikasi
// ==============================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('staff.dashboard');
    });

    // ==============================
    // Staff / Unit Kerja -> Purchase Request
    // ==============================
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'staff'])->name('dashboard');
        Route::resource('purchase-requests', \App\Http\Controllers\PurchaseRequestController::class)
            ->except(['edit', 'update']);
    });

    // ==============================
    // Approver / Manajer -> Persetujuan PR
    // ==============================
    Route::middleware('role:approver')->prefix('approver')->name('approver.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'approver'])->name('dashboard');
        Route::get('/purchase-requests', [\App\Http\Controllers\ApprovalController::class, 'index'])->name('purchase-requests.index');
        Route::get('/purchase-requests/{purchaseRequest}', [\App\Http\Controllers\ApprovalController::class, 'show'])->name('purchase-requests.show');
        Route::post('/purchase-requests/{purchaseRequest}/approve', [\App\Http\Controllers\ApprovalController::class, 'approve'])->name('purchase-requests.approve');
        Route::post('/purchase-requests/{purchaseRequest}/reject', [\App\Http\Controllers\ApprovalController::class, 'reject'])->name('purchase-requests.reject');
    });

    // ==============================
    // Staff Pengadaan -> Vendor, PO, Goods Receipt
    // ==============================
    Route::middleware('role:procurement')->prefix('procurement')->name('procurement.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'procurement'])->name('dashboard');

        Route::resource('vendors', \App\Http\Controllers\VendorController::class);
        Route::resource('items', \App\Http\Controllers\ItemController::class);

        Route::get('/purchase-requests', [\App\Http\Controllers\PurchaseOrderController::class, 'approvedRequests'])->name('purchase-requests.approved');
        Route::resource('purchase-orders', \App\Http\Controllers\PurchaseOrderController::class)
            ->except(['edit', 'update']);
        Route::get('/purchase-orders/{purchaseOrder}/pdf', [\App\Http\Controllers\PurchaseOrderController::class, 'downloadPdf'])->name('purchase-orders.pdf');

        Route::resource('goods-receipts', \App\Http\Controllers\GoodsReceiptController::class)
            ->except(['edit', 'update']);
    });

    // ==============================
    // Vendor / Supplier
    // ==============================
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'vendor'])->name('dashboard');
        Route::get('/purchase-orders', [\App\Http\Controllers\VendorPortalController::class, 'index'])->name('purchase-orders.index');
        Route::post('/purchase-orders/{purchaseOrder}/confirm', [\App\Http\Controllers\VendorPortalController::class, 'confirmDelivery'])->name('purchase-orders.confirm');
    });

    // ==============================
    // Super Admin -> Full Access
    // ==============================
    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // Laporan pengadaan
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });
});
