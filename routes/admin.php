<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\UniversiteController;
use App\Http\Controllers\Admin\UsersController;
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

        Route::resource('/universites/{universite}/sites', SiteController::class);

        Route::resource('/sites/{site}/filieres', FiliereController::class);

        Route::controller(UsersController::class)->group(function () {

            Route::get('/users', 'indexUsers')->name('users.index');

            Route::get('/user/{user}', 'showUser')->name('user.show');

            Route::post('/user/{user}/mail', 'messageUser')->name('user.email');

            Route::post('/user/{user}/block', 'blockUser')->name('block.user');

            Route::post('/user/{user}/free', 'freeUser')->name('free.user');

            Route::delete('/user/{user}/delete', 'deleteUser')->name('delete.user');
        });

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});
