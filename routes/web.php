<?php

use App\Http\Controllers\ManagerAuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Profile\PasswordController;
use App\Http\Controllers\Profile\ProfileAvatarController;
use App\Http\Controllers\Profile\ProfileInformationController;
use App\Http\Controllers\SellerController;
use App\Models\Manager;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

//Middleware en grupo, para autenticacion como primer punto

Route::middleware(['auth:web', 'verified'])->group(function ()
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


     
//---------------------------user

Route::prefix('user')->name('user.')->group( function(){

    Route::middleware(['guest:web'])->group(function(){
        Route::view('/login', 'dashboard.user.login')->name('login');
    });
    
    Route::middleware(['auth:web','verified'])->group(function(){
        Route::view('/home', 'dashboard.user.home')->name('home');
    });
});


//---------------------------manager

Route::prefix('manager')->name('manager.')->group( function(){

    Route::middleware(['guest:manager'])->group(function(){
        Route::view('/login', 'dashboard.manager.login')->name('login');
        Route::post('/check', [ManagerAuthController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:manager','verified'])->group(function(){
        Route::view('/home', 'dashboard.manager.home')->name('home');
    });

});
    


require __DIR__.'/auth.php';
