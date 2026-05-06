<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            return $this->loginOrCreateUser($socialUser, 'google');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google. Silakan coba lagi.');
        }
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $socialUser = Socialite::driver('github')->user();
            return $this->loginOrCreateUser($socialUser, 'github');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk dengan GitHub. Silakan coba lagi.');
        }
    }

    private function loginOrCreateUser($socialUser, string $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'              => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email'             => $socialUser->getEmail(),
                'google_id'         => $provider === 'google' ? $socialUser->getId() : null,
                'password'          => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
            ]);
        } else {
            if ($provider === 'google' && !$user->google_id) {
                $user->update(['google_id' => $socialUser->getId()]);
            }
        }

        Auth::login($user, true);
        return redirect()->intended(route('beranda'));
    }
}
