<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MenuController;

use App\Http\Middleware\IsSupervisor;
use App\Http\Middleware\CheckLogin;

/* =====================================
=            LOGIN ROUTES              =
===================================== */

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    dd([
    'env_session_driver' => env('SESSION_DRIVER'),
    'config_session_driver' => config('session.driver'),
    'app_env' => env('APP_ENV'),
]);

    $request->validate([
        'username' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // ✅ Check BOTH username + email
    $user = User::where('username', $request->username)
                ->where('email', $request->email)
                ->first();

    if (!$user) {
        return back()->with('error', 'Invalid credentials');
    }

    // ✅ Password check
    if (!Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid credentials');
    }

    // ✅ Normalize role (IMPORTANT)
    $role = strtolower($user->role);

    session([
        'user_id' => $user->id,
        'role' => $role
    ]);

    // ✅ Redirect based on role
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'supervisor') {
        return redirect()->route('supervisor.dashboard');
    } else {
        return redirect()->route('manager.dashboard');
    }

});

/* =====================================
=            LOGOUT                    =
===================================== */

Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');

/* =====================================
=            DEFAULT                   =
===================================== */

Route::get('/', function () {
    return redirect('/login');
});

/* =====================================
=            ADMIN ROUTES              =
===================================== */

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['check.login', 'is.admin'])
    ->group(function () {

        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('suppliers', SupplierController::class);
        Route::resource('employees', EmployeeController::class);

        Route::resource('items', ItemController::class);

        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('menu', [MenuController::class, 'index'])->name('menu');

Route::post('menu', [MenuController::class, 'store'])->name('menu.store');

Route::delete('menu/{id}', [MenuController::class, 'destroy'])->name('menu.delete');
    });

/* =====================================
=         SUPERVISOR ROUTES            =
===================================== */

Route::prefix('supervisor')
    ->name('supervisor.')
    ->middleware([CheckLogin::class, IsSupervisor::class])
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [SupervisorController::class, 'dashboard'])
            ->name('dashboard');

        // ORDERS (FIXED HERE)
        Route::get('orders', [SupervisorController::class, 'orders'])
            ->name('orders.index');

        // OPTIONAL: if you want history separate
        Route::get('history', [SupervisorController::class, 'history'])
            ->name('history');

        // Suppliers
        Route::get('suppliers', [SupplierController::class, 'supervisorIndex'])
            ->name('suppliers');

        // Approve order
        Route::post('orders/{order}/approve', [SupervisorController::class, 'approveOrder'])
            ->name('orders.approve');

        // Cancel order
        Route::post('orders/{order}/cancel', [SupervisorController::class, 'cancelOrder'])
            ->name('orders.cancel');

        // Adjustments
        Route::post('adjustment/{id}/approve', [SupervisorController::class, 'approveAdjustment'])
            ->name('adjustment.approve');

        Route::post('adjustment/{id}/reject', [SupervisorController::class, 'rejectAdjustment'])
            ->name('adjustment.reject');

        // Supplies
        Route::get('supplies', [SupervisorController::class, 'supplies'])
            ->name('supplies');
    });

/* =====================================
=         STORE MANAGER ROUTES         =
===================================== */

Route::prefix('manager')
    ->name('manager.')
    ->middleware([CheckLogin::class])
    ->group(function () {

        Route::get('dashboard', [ManagerController::class, 'dashboard'])
            ->name('dashboard');

        /* =========================
           POS (SALES SYSTEM)
        ========================= */

        Route::post('pos/store', [OrderController::class, 'storePOS'])
            ->name('pos.store');

        Route::get('menu', [MenuController::class, 'index'])
            ->name('menu.index');

        /* =========================
           PURCHASE ORDERS
        ========================= */

        Route::get('orders', [OrderController::class, 'managerOrders'])
            ->name('orders.index');

        Route::post('orders/store', [OrderController::class, 'store'])
            ->name('orders.store');

        Route::post('orders/purchase/store', [OrderController::class, 'storePurchaseOrder'])
            ->name('orders.purchase.store');

        Route::post('orders/{order}/cancel', [OrderController::class, 'managerCancel'])
            ->name('orders.cancel');

        Route::post('orders/{order}/confirm-delivery', [OrderController::class, 'confirmDelivery'])
            ->name('orders.confirmDelivery');

        /* =========================
           ITEMS
        ========================= */

        Route::get('items', [ItemController::class, 'managerIndex'])
            ->name('items.index');

        Route::get('items/create', [ItemController::class, 'create'])
            ->name('items.create');

        Route::post('items', [ItemController::class, 'store'])
            ->name('items.store');

        Route::get('items/{item}/edit', [ItemController::class, 'edit'])
            ->name('items.edit');

        Route::put('items/{item}', [ItemController::class, 'update'])
            ->name('items.update');

        Route::delete('items/{item}', [ItemController::class, 'destroy'])
            ->name('items.destroy');

        Route::post('items/{item}/stock', [ItemController::class, 'updateStock'])
            ->name('items.updateStock');

        /* =========================
           ADJUSTMENTS
        ========================= */

        Route::post('adjustment/store', [ItemController::class, 'storeAdjustment'])
            ->name('adjustment.store');
    });