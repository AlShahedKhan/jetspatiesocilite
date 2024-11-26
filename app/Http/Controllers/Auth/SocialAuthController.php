<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Laravel\Socialite\Facades\Socialite;

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

            // Log the Socialite user data for debugging
            \Log::info('Socialite User Data:', [
                'id' => $socialUser->getId(),
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
            ]);

            // Find user by provider ID or email
            $user = User::where('provider_id', $socialUser->getId())
                ->orWhere('email', $socialUser->getEmail())
                ->first();

            // If user doesn't exist, create a new one
            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'GitHub User', // Handle null name by using nickname as fallback
                    'email' => $socialUser->getEmail(),
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            // Log the user in
            Auth::guard('web')->login($user, true);

            // Check if the user is logged in successfully
            if (Auth::check()) {
                \Log::info('User logged in successfully', ['user_id' => Auth::id()]);
            } else {
                \Log::error('User login failed');
                return redirect('/')->withErrors(['error' => 'Login failed. Please try again.']);
            }

            // Redirect to dashboard
            return redirect('/dashboard')->with('status', 'Login successful');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect('/')->withErrors(['error' => 'This email is already registered with another account.']);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect('/')->withErrors(['error' => 'Authentication failed.']);
        }
    }


    // public function callback($provider)
    // {
    //     try {
    //         $socialUser = Socialite::driver($provider)->stateless()->user();

    //         $user = User::where('provider_id', $socialUser->getId())
    //             ->orWhere('email', $socialUser->getEmail())
    //             ->first();

    //         if (!$user) {
    //             $user = User::create([
    //                 'name' => $socialUser->getName(),
    //                 'email' => $socialUser->getEmail(),
    //                 'provider_name' => $provider,
    //                 'provider_id' => $socialUser->getId(),
    //                 'password' => bcrypt(Str::random(16)),
    //             ]);
    //         }

    //         // Use Sanctum guard for login
    //         Auth::guard('web')->login($user, true);

    //         return redirect('/dashboard');
    //     } catch (QueryException $e) {
    //         if ($e->getCode() === '23000') {
    //             return redirect('/')->withErrors(['error' => 'This email is already registered with another account.']);
    //         }
    //         throw $e;
    //     }
    // }
}
