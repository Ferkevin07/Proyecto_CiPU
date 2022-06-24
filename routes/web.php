<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Profile\PasswordController;
use App\Http\Controllers\Profile\ProfileAvatarController;
use App\Http\Controllers\Profile\ProfileInformationController;
use App\Http\Controllers\SellerController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

//Middleware en grupo, para autenticacion como primer punto

Route::middleware(['auth', 'verified'])->group(function ()
{
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/profile', [ProfileInformationController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileInformationController::class, 'update'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('user-password.update');
    //Route::put('/user-avatar', [ProfileAvatarController::class, 'update'])->name('user-avatar.update');

});

    Route::get('/sellers', [SellerController::class, 'index'])->name('seller.index');
    Route::get('/sellers/create', [SellerController::class, 'create'])->name('seller.create');
    Route::post('/sellers/create', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/sellers/{manager}', [SellerController::class, 'show'])->name('seller.show');
    Route::get('/sellers/update/{manager}', [SellerController::class, 'edit'])->name('seller.edit');
    Route::put('/sellers/update/{manager}', [SellerController::class, 'update'])->name('seller.update');
    Route::get('/sellers/destroy/{manager}', [SellerController::class, 'destroy'])->name('seller.destroy');

require __DIR__.'/auth.php';
