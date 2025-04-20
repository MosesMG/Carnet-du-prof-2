<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoolgeController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'social_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()),
                    session()->put('avatar', $googleUser->getAvatar()),
                ]
            );

            Auth::guard('web')->login($user);

            return redirect()->intended(route('dashboard'));
        }
        catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Erreur de connexion avec Google'
            ]);
        }
    }
}
