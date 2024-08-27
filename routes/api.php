<?php
  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user-count', [UserController::class, 'getUserCount']);
