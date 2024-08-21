<?php
  
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FlaskApiController;
use App\Http\Controllers\Auth\GoogleController;

// In web.php

Route::get('/', [HomeController::class, 'welcome']);
// In routes/web.php
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');



Auth::routes();

Route::get('/home', function () {
    $userCount = app(UserController::class)->getUserCount();
    $postCount = app(PostController::class)->getPostCount();
    $pendingCount = app(UserController::class)->getPendingCount();
    $pendingPost = app(PostController::class)->getPendingPosts();
    return view('home', compact('userCount', 'postCount','pendingCount','pendingPost'));
})->name('home');


Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);

   
    Route::post('users/{id}/accept', [UserController::class, 'accept'])->name('users.accept');
    Route::delete('users/{id}/reject', [UserController::class, 'reject'])->name('users.reject');
});
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::middleware(['auth'])->group(function () {
    Route::post('posts/{id}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::post('posts/{id}/reject', [PostController::class, 'reject'])->name('posts.reject');
});



Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

Route::get('featured-post/{id}', [PostController::class, 'showFeatured'])->name('posts.showFeatured');


Route::middleware('auth')->group(function () {
    Route::get('my-posts', [PostController::class, 'userIndex'])->name('posts.userIndex');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
});





Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');


Route::post('/posts/{postId}/comment', [PostController::class, 'addComment'])->name('posts.addComment');


Route::get('posts/search', [PostController::class, 'search'])->name('posts.search');
Route::get('posts', [PostController::class, 'index'])->name('posts.index');


Route::get('/users/approved', [UserController::class, 'approved'])->name('users.approved');

Route::post('/posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
Route::post('/posts/{post}/reject', [PostController::class, 'reject'])->name('posts.reject');
// Users routes
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');


// web.php

// In routes/web.php

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    // other admin routes...

    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');
    Route::get('/admin/posts', [PostController::class, 'index'])->name('admin.posts');
});


Route::post('/users/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
Route::delete('/users/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');

// In routes/web.php

Route::get('/user-list', [UserController::class, 'list'])->name('user.list');


Route::post('/upload/froala', [PostController::class, 'uploadImage'])->name('upload.froala');
// Route to handle chat API requests
// Add this route to your routes/web.php
Route::get('/chat-form', function () {
    return view('chat-form');
});

Route::post('/chat', [FlaskApiController::class, 'chat'])->name('flask.chat');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
