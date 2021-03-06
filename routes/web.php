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

    Route::post('/upload', [App\Http\Controllers\ProfileController::class, 'upload'])->name('upload');

    Route::post('/postEdit', [App\Http\Controllers\PostController::class, 'update'])->name('postEdit');

    Route::post('/postDelete', [App\Http\Controllers\PostController::class, 'delete'])->name('postDelete');

    Route::get('/profile/{user}', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

    Route::get('/getPosts/{user}', [App\Http\Controllers\ProfileController::class, 'getPosts'])->name('getPosts');

    Route::post('/likePost', [App\Http\Controllers\PostController::class, 'likePost'])->name('likePost');

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
