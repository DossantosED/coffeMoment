<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){

    Route::post('/postCreate', [App\Http\Controllers\PostController::class, 'create'])->name('postCreate');

    Route::post('/postEdit', [App\Http\Controllers\PostController::class, 'edit'])->name('postEdit');

    Route::post('/postDelete/{id}', [App\Http\Controllers\PostController::class, 'delete'])->name('postDelete');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
