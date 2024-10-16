<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TestController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/Step7', [App\Http\Controllers\TestController::class, 'showList'])->name('List');

Route::get('/Step7/search', [App\Http\Controllers\TestController::class, 'exeSearch'])->name('search');

Route::get('/Step7/create', [App\Http\Controllers\TestController::class, 'createList'])->name('create');
Route::post('/Step7/store', [App\Http\Controllers\TestController::class, 'exeStore'])->name('store');

Route::get('/Step7/detail/{id}', [App\Http\Controllers\TestController::class, 'showDetail'])->name('detail');

Route::get('/Step7/edit/{id}', [App\Http\Controllers\TestController::class, 'editDetail'])->name('edit');
Route::put('/Step7/update/{id}', [App\Http\Controllers\TestController::class, 'exeUpdate'])->name('update');

Route::delete('/Step7/delete/{id}', [App\Http\Controllers\TestController::class, 'exeDelete'])->name('delete');