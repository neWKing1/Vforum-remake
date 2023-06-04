<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

// Route::resource('posts', App\Http\Controllers\PostController::class);
Route::resource('tags', App\Http\Controllers\TagController::class)->middleware('auth');
// Route::resource('comments', App\Http\Controllers\CommentController::class);
Route::group(['middlware' => 'auth', 'prefix' => '/comments'], function () {
    Route::post('', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/edit', [App\Http\Controllers\CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});
// Route::get('/home',)->name('home');
Route::group(['middleware' => 'auth', 'prefix' => '/posts'], function () {
    Route::get('/create', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
    Route::post('', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::put('/{post}', [App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
    Route::get('/{post}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
    Route::delete('/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
});
Route::group(['prefix' => '/posts'], function () {
    Route::get('', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
    Route::get('/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
});
Route::group(['middleware' => 'auth', 'prefix' => '/comments'], function () {
    Route::post('', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
});
// Route::post('test', function () {
//     return 'Success!';
// });
