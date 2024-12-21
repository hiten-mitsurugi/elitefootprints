<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    // Redirect to Google OAuth
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect(); // No `prompt` parameter to skip account chooser
    }

    // Handle Google callback
    public function callback($provider)
    {
        try {
            // Get user data from Google in stateless mode
            $googleUser = Socialite::driver($provider)->stateless()->user();

            // Ensure required data exists
            if (!$googleUser->getEmail()) {
                return redirect()->route('login')->with('error', 'Google did not provide a valid email address.');
            }

            // Find or create the user
            $user = User::firstOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name' => $googleUser->getName() ?: 'Unknown', // Fallback if name is empty
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(uniqid()), // Generate a random password
                    'role' => 'Customer', // Default role (e.g., customer)
                ]
            );

            // If the user is new, trigger the Registered event
            if ($user->wasRecentlyCreated) {
                event(new Registered($user));
            }

            // Log in the user directly
            Auth::login($user, true);

            return redirect()->route('shop'); // Redirect to dashboard or shop
        } catch (\Exception $e) {
            // Log the error and return to the login page with a message
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Something went wrong during login.');
        }
    }
}
