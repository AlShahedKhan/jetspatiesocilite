<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            $user = User::where('provider_id', $socialUser->getId())
                ->orWhere('email', $socialUser->getEmail())
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            // Use Sanctum guard for login
            Auth::guard('web')->login($user, true);

            return redirect('/dashboard');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect('/')->withErrors(['error' => 'This email is already registered with another account.']);
            }
            throw $e;
        }
    }
}
