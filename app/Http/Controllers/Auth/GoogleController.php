<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Route;

   
class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }



 

public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::where('email', $googleUser->email)->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => \Hash::make(rand(100000, 999999))
        ]);
    }

    Auth::login($user);

    // Use route() helper to generate the correct URL for the named route
    return redirect()->route('posts.index');
}

    
}
