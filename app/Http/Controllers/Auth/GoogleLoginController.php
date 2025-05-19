<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari atau buat pengguna
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(24)),
                    'google_id' => $googleUser->getId(),
                ]
            );

            // Simpan foto profil dari Google jika belum ada
            if ($googleUser->getAvatar() && !$user->hasMedia('profile_photo')) {
                try {
                    $response = Http::get($googleUser->getAvatar());
                    if ($response->successful()) {
                        $user->addMediaFromUrl($googleUser->getAvatar())
                            ->toMediaCollection('profile_photo');
                        Log::info('Profile photo saved from Google', ['user_id' => $user->id, 'avatar_url' => $googleUser->getAvatar()]);
                    } else {
                        Log::warning('Failed to fetch Google avatar', ['user_id' => $user->id, 'url' => $googleUser->getAvatar()]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to save Google profile photo', ['user_id' => $user->id, 'error' => $e->getMessage()]);
                }
            }

            Auth::login($user, true);
            session()->regenerate();

            Log::info('User logged in via Google', ['user_id' => $user->id]);

            return redirect('/profile');
        } catch (\Exception $e) {
            Log::error('Google login failed', ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}