<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\IsSupervisor;
use App\Http\Middleware\CheckLogin;

/* ===== LOGIN ===== */
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {

    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {

        session([
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        }

        return redirect('/login');
    }

    return back()->with('error', 'Invalid credentials');
});

/* ===== LOGOUT ===== */
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');

/* ===== DEFAULT ===== */
Route::get('/', function () {
    return redirect('/login');
});

/* ===== ADMIN ===== */
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['check.login', 'is.admin'])
    ->group(function() {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('orders', OrderController::class)->only(['index']);
});

/* ===== SUPERVISOR ===== */
Route::prefix('supervisor')
    ->name('supervisor.')
    ->middleware([CheckLogin::class, IsSupervisor::class])
    ->group(function() {

        Route::get('dashboard', function () {
            return view('supervisor.dashboard');
        })->name('dashboard');

        Route::resource('orders', OrderController::class)->only(['index']);
        Route::get('history', [OrderController::class, 'history'])->name('history');
        Route::get('suppliers', [SupplierController::class, 'supervisorIndex'])->name('suppliers');
});