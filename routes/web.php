<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
   
Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
});


// Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');


// Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');

Route::post('users/{id}/accept', [UserController::class, 'accept'])->name('users.accept');
Route::delete('users/{id}/reject', [UserController::class, 'reject'])->name('users.reject');

