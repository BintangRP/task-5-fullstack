<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('/layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/articles/create', [App\Http\Controllers\HomeController::class, 'create']);
Route::post('/articles/create', [App\Http\Controllers\HomeController::class, 'store']);
Route::get('/articles/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit']);
Route::delete('/articles/{id}', [App\Http\Controllers\HomeController::class, 'destroy']);
Route::put('/articles/edit/{id}', [App\Http\Controllers\HomeController::class, 'update']);

Route::get('/category', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
Route::delete('/category/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);
Route::put('/category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.edit');
