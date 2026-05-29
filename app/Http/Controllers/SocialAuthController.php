<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'provider_name' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } elseif (!$user->provider_id) {
                // If user exists but hasn't linked Google account, link it now
                $user->update([
                    'provider_name' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $user->avatar ?? $googleUser->getAvatar(),
                ]);
            }

            Auth::login($user);

            return redirect()->intended(route('user.dashboard'));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Socialite Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google. Silakan coba lagi. ' . $e->getMessage());
        }
    }
}
