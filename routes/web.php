<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Profile\PasswordController;
use App\Http\Controllers\Profile\ProfileAvatarController;
use App\Http\Controllers\Profile\ProfileInformationController;


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

require __DIR__.'/auth.php';
