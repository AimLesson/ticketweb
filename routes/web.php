<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Home.home');
});
Route::get('/lineup', function () {
    return view('Home.lineup');
});
Route::get('/merch', function () {
    return view('Home.merch');
});
Route::get('/about', function () {
    return view('Home.about');
});
Route::get('/faq', function () {
    return view('Home.faq');
});

Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::view('/pay', 'Home.pay');
Route::post('/pay/verify', [TransaksiController::class, 'verifyPayment'])->name('pay.verify');
Route::get('/verify-transaction', [TransaksiController::class, 'verifyTransaction']);
Route::post('/pay/upload', [TransaksiController::class, 'uploadFile']);
Route::post('/transaksi/update-status/{id}', [TransaksiController::class, 'updateStatus']);

Route::get('/dashboard', [TransaksiController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/claim', [ClaimController::class, 'showClaimForm'])->name('claim.show');
Route::get('/claim/verify', [ClaimController::class, 'verifyClaim'])->name('claim.verify');


require __DIR__.'/auth.php';
