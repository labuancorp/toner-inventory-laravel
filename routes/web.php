<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\MfaSettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PublicReportsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ShopHistoryController;
// use App\Http\Controllers\ShopReportController; // removed: shop report feature

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Admin dashboard (Material UI)
Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin,manager'])
    ->name('admin.dashboard');

// Public shop & ordering
Route::get('/shop', [OrderController::class, 'index'])->name('shop');
// Restrict order placement to authenticated users
Route::post('/order', [OrderController::class, 'store'])
    ->middleware(['auth'])
    ->name('order.store');
// Personal usage report in Shop — removed per request

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MFA settings
    Route::put('/profile/mfa', [MfaSettingsController::class, 'update'])->name('mfa.settings.update');

    // Read-only inventory routes restricted to admin/manager roles
    Route::get('items', [ItemController::class, 'index'])->middleware('role:admin,manager')->name('items.index');
    Route::get('items/trashed', [ItemController::class, 'trashed'])->middleware('role:admin,manager')->name('items.trashed');
    Route::get('items/reorder', [ItemController::class, 'reorderSuggestions'])->middleware('role:admin,manager')->name('items.reorder');
    Route::get('items/scan', [ItemController::class, 'scan'])->middleware('role:admin,manager')->name('items.scan');
    Route::get('items/lookup/{sku}', [ItemController::class, 'lookupBySku'])->middleware('role:admin,manager')->name('items.lookup');
    // JSON endpoint for polling fallback on item page
    Route::get('items/{item}/json', [ItemController::class, 'showJson'])->middleware('role:admin,manager')->name('items.show.json')->whereNumber('item');
    // Show route must come after specific paths and be constrained
    Route::get('items/{item}', [ItemController::class, 'show'])->middleware('role:admin,manager')->name('items.show')->whereNumber('item');

    // Inventory management restricted to admin or manager roles
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        // Limit item resource to write operations only
        Route::resource('items', ItemController::class)->except(['index','show']);
        Route::post('items/{item}/adjust-stock', [ItemController::class, 'adjustStock'])->name('items.adjustStock');
        Route::delete('items/{item}/image', [ItemController::class, 'destroyImage'])->name('items.image.destroy');
        Route::post('items/{id}/restore', [ItemController::class, 'restore'])->name('items.restore');
        Route::post('items/{item}/notify-reorder', [ItemController::class, 'notifyReorder'])->name('items.notifyReorder');

        // Printers management & maintenance scheduling
        Route::resource('printers', PrinterController::class);
        Route::post('printers/{printer}/service', [PrinterController::class, 'markServiced'])->name('printers.service');
        Route::post('printers/notify-due', [PrinterController::class, 'notifyDue'])->name('printers.notifyDue');
        Route::delete('printers/{printer}/image', [PrinterController::class, 'destroyImage'])->name('printers.image.destroy');
        Route::get('printers/docs', [PrinterController::class, 'docs'])->name('printers.docs');

        // Admin users management
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', UserManagementController::class)->only(['index', 'create', 'store', 'edit', 'update']);
            Route::post('users/{user}/send-reset', [UserManagementController::class, 'sendReset'])->name('users.sendReset');
            Route::post('users/bulk/roles', [UserManagementController::class, 'bulkUpdateRoles'])->name('users.bulk.roles');
            Route::post('users/bulk/resets', [UserManagementController::class, 'bulkSendResets'])->name('users.bulk.resets');
            Route::get('users/export', [UserManagementController::class, 'export'])->name('users.export');

            // Agency settings (restricted to admin/manager)
            Route::get('settings', [SettingsController::class, 'index'])->middleware('role:admin,manager')->name('settings.index');
            Route::post('settings/logo', [SettingsController::class, 'updateLogo'])->middleware('role:admin,manager')->name('settings.logo.update');
        });
    });

    // Notifications
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    // Reports
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])
        ->middleware('role:admin,manager')
        ->name('reports.inventory');
    Route::get('/reports/analytics', [AnalyticsController::class, 'index'])->name('reports.analytics');
    Route::get('/reports/analytics/yearly', [AnalyticsController::class, 'yearly'])->name('reports.analytics.yearly');
    Route::get('/reports/analytics/yearly/export', [AnalyticsController::class, 'exportYearly'])->name('reports.analytics.yearly.export');
    // Public-friendly reports for normal users (no inventory details)
    Route::get('/reports/public', [PublicReportsController::class, 'index'])->name('reports.public');

    // Shop History (audit of orders/withdrawals)
    Route::get('/shop/history', [ShopHistoryController::class, 'index'])->name('shop.history');
    Route::get('/shop/history/export', [ShopHistoryController::class, 'export'])->name('shop.history.export');
});

require __DIR__.'/auth.php';

// Graceful fallback for accidental GET /logout visits
// Do not log out on GET; instruct clients to use the POST logout button
Route::get('/logout', function () {
    return redirect()->route('dashboard')->with('status', 'Use the Log Out button; logout requires POST.');
})->middleware('auth')->name('logout.get');

// Language switching
Route::post('/locale', [LocaleController::class, 'switch'])->name('locale.switch');
