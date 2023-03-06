<?php

use App\Http\Controllers\Daftar;
use App\Http\Controllers\Superadmin\SuperAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\SaUserController;
use App\Http\Controllers\Superadmin\HakAksesController;
use App\Http\Controllers\Superadmin\CreateTableController;
use App\Http\Controllers\Superadmin\TesController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/daftar', [Daftar::class, 'index'])->name('daftar');
    Route::post('/daftar', [Daftar::class, 'store'])->name('daftar.store');
    Route::get('/login', [Daftar::class, 'login'])->name('login');
    Route::post('/login', [Daftar::class, 'create'])->name('login.create');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [Daftar::class, 'logout'])->name('logout');
    Route::resource('menumanagemen', SuperAdmin::class);
    Route::resource('sauser', SaUserController::class);
    Route::resource('akses', HakAksesController::class);
    Route::resource('createTable', CreateTableController::class);
    Route::resource('tes', TesController::class);
});
