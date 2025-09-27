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
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\PrinterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin dashboard (Material UI)
Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin,manager'])
    ->name('admin.dashboard');

// Public shop & ordering
Route::get('/shop', [OrderController::class, 'index'])->name('shop');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MFA settings
    Route::put('/profile/mfa', [MfaSettingsController::class, 'update'])->name('mfa.settings.update');

    // Inventory management restricted to admin or manager roles
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('items', ItemController::class);
        Route::post('items/{item}/adjust-stock', [ItemController::class, 'adjustStock'])->name('items.adjustStock');
        Route::delete('items/{item}/image', [ItemController::class, 'destroyImage'])->name('items.image.destroy');
        Route::get('items/trashed', [ItemController::class, 'trashed'])->name('items.trashed');
        Route::post('items/{id}/restore', [ItemController::class, 'restore'])->name('items.restore');
        Route::get('items/reorder', [ItemController::class, 'reorderSuggestions'])->name('items.reorder');
        Route::get('items/scan', [ItemController::class, 'scan'])->name('items.scan');
        Route::get('items/lookup/{sku}', [ItemController::class, 'lookupBySku'])->name('items.lookup');
        Route::post('items/{item}/notify-reorder', [ItemController::class, 'notifyReorder'])->name('items.notifyReorder');
        // JSON endpoint for polling fallback on item page
        Route::get('items/{item}/json', [ItemController::class, 'showJson'])->name('items.show.json');

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
        });
    });

    // Notifications
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    // Reports
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
});

require __DIR__.'/auth.php';

// Graceful fallback for accidental GET /logout visits
// Do not log out on GET; instruct clients to use the POST logout button
Route::get('/logout', function () {
    return redirect()->route('dashboard')->with('status', 'Use the Log Out button; logout requires POST.');
})->middleware('auth')->name('logout.get');
