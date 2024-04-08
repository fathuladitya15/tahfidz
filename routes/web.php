<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HafalanController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('user')->group(function() {
    Route::get('index',[UserController::class,'index'])->name('user-index');
    Route::get('create',[UserController::class,'create'])->name('user-create');
    Route::post('store',[UserController::class,'store'])->name('user-store');
    Route::get('data',[UserController::class,'data'])->name('user-data');
    Route::get('edit/{id}',[UserController::class,'edit'])->name('user-edit');
});
Route::prefix('hafalan')->group(function() {
    Route::get('index',[HafalanController::class,'index'])->name('hafalan-index');
});
