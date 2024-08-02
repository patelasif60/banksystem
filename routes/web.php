<?php

use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\AccountController;
use App\Http\Controllers\frontend\TransactionController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('login', function() {return view('auth.login');})->name('loginview');
Route::get('register', function() { return view('auth.register');})->name('registerview');
Route::post('login',[AuthController::class, 'login'])->name('login');
Route::post('register',[AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('verify',[AuthController::class, 'twoStepView'])->name('verify');
    Route::post('verify',[AuthController::class, 'verifyCode'])->name('verify.store');
    Route::get('verify/resend', [AuthController::class, 'twoStepView'])->name('verify.resend');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth','twofactor')->group(function () {
    Route::get('home', function() {
        return view('home');
    });
});
Route::middleware(['auth','twofactor','isadmin'])->group(function () {
    Route::get('admin/dashboard', function() {return view('dashboard');})->name('dashboard');
    Route::get('admin/users', [AccountController::class, 'index'])->name('users.index');
    Route::get('admin/addaccount', [AccountController::class, 'create'])->name('account.create');
    Route::post('admin/storeaccount', [AccountController::class, 'store'])->name('account.store');
    Route::post('admin/changestatus', [AccountController::class, 'changestatus'])->name('accounts.statuschange');
    Route::get('admin/accountdetail/{id}',[AccountController::class, 'accountDetail'])->name('admin.accountdetail');
    Route::get('admin/transferhistory/{id}',[TransactionController::class, 'transferhistory'])->name('admin.transferhistory');
});
Route::middleware(['auth','twofactor','isuser'])->group(function () {
    Route::get('dashboard', function() {return view('frontend.dashboard');})->name('forntdashboard');
    Route::get('accountdetail/{id}',[AccountController::class, 'accountDetail'])->name('accountdetail');
    Route::get('fundtransfer',[TransactionController::class, 'fundTransferView'])->name('fundtransfer');
    Route::post('fundtransfer',[TransactionController::class, 'transfer'])->name('transfer');
    Route::get('transferhistory/{id}',[TransactionController::class, 'transferhistory'])->name('transferhistory');
});
       