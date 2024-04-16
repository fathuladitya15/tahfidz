<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth')->group(function() {
    Route::prefix('home')->group(function() {
        Route::get('index',[HomeController::class,'index'])->name('home');
        Route::get('profile',[ProfileController::class,'index'])->name('profile');
    });
    Route::prefix('user')->group(function() {
        Route::get('index',[UserController::class,'index'])->name('user-index');
        Route::get('create',[UserController::class,'create'])->name('user-create');
        Route::post('store',[UserController::class,'store'])->name('user-store');
        Route::get('data',[UserController::class,'data'])->name('user-data');
        Route::get('edit/{id}',[UserController::class,'edit'])->name('user-edit');
        Route::post('update',[UserController::class,'update'])->name('user-update');
    });
    Route::prefix('hafalan')->group(function() {
        Route::get('index',[HafalanController::class,'index'])->name('hafalan-index');
        Route::get('data',[HafalanController::class,'data'])->name('hafalan-data');
    });

});
