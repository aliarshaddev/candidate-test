<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
class CustomAuthService
{
    public function login($email, $password)
    {
        // Check if a user with the same email already exists
        $existingUser = User::where('email', $email)->first();
        if($existingUser)
        {
            $existingUserArray = $existingUser->toArray();
            $data = $this->checkToken($existingUserArray);
            if($data)
            {
                session(['access_token' => $data['token_key'], 'access_token_expires_at' => $data['expires_at'], 'access_token_refresh_key' => $data['refresh_token_key']]);
                $existingUser->update([
                    'refresh_token_key' => $data['refresh_token_key'],
                    'token_key' => $data['token_key'],
                    'expires_at' => $data['expires_at'],
                ]);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            $data = $this->getToken($email, $password);
            if($data)
            {
                // Create a new user
                $user = new User();
                $user->first_name = $data['user']['first_name'];
                $user->last_name = $data['user']['last_name'];
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->refresh_token_key = $data['refresh_token_key'];
                $user->token_key = $data['token_key'];
                $user->expires_at = $data['expires_at'];
                $user->save();
                session(['access_token' => $data['token_key'], 'access_token_expires_at' => $data['expires_at'], 'access_token_refresh_key' => $data['refresh_token_key']]);
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    function getToken($email, $password)
    {
        // Make an API request to log in the user
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('api.auth_token'),
        ])->post(config('api.base_url').'/token', [
            'email' => $email,
            'password' => $password,
        ]);
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }
        else
        {
            return false;
        }
    }
    function checkToken($existingUser)
    {
        $accessTokenExpiration = $existingUser['expires_at'];
        // Check if the access token has expired
        if (now()->gte($accessTokenExpiration)) {
            // Regenerate the token (make a request to your API to get a new token)
            $accessTokenRefreshKey = session('access_token_refresh_key');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('api.auth_token'),
            ])->get(config('api.base_url').'/token/refresh/'.$accessTokenRefreshKey);

            if ($response->successful()) {
                $data = $response->json();
                return $data;
            } else {
                // Handle token regeneration error
                return false;
            }
        }
        else
        {
            return $existingUser;
        }
    }
}
