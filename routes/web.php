<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;

/* LOGIN */
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

use App\Models\User;

Route::post('/login', function (Illuminate\Http\Request $request) {

    $user = User::where('username', $request->username)->first();

    if ($user && $user->password === $request->password) {

        session([
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/login'); // fallback
    }

    return back()->with('error', 'Invalid credentials');
});

/* DEFAULT */
Route::get('/', function () {
    return redirect('/login');
});

/* ADMIN */
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('orders', OrderController::class)->only(['index']);
});
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['check.login', 'is.admin'])
    ->group(function() {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('orders', OrderController::class)->only(['index']);
});
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');