<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {});

    Route::middleware('auth:admin')->group(function () {});
});