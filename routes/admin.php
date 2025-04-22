<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\UniversiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {

        Route::get('/', [AuthController::class, 'login']);
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'doLogin']);

        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'create']);

        Route::get('forgot-password', [AuthController::class, 'forgotPassword'])
            ->name('password.request');

        Route::post('forgot-password', [AuthController::class, 'submitEmail'])
            ->name('password.email');

        Route::get('reset-password/{token}', [AuthController::class, 'newPassword'])
            ->name('password.reset');

        Route::post('reset-password', [AuthController::class, 'submitPassword'])
            ->name('password.store');
    });

    Route::middleware('auth:admin')->group(function () {

        Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/home', [HomepageController::class, 'accueil'])->name('accueil');

        Route::resource('/universites', UniversiteController::class);
    });
});
