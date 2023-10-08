<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
class CheckAccessTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessTokenExpiration = session('access_token_expiration');

        // Check if the access token has expired
        if (now()->gte($accessTokenExpiration)) {
            // Regenerate the token (make a request to your API to get a new token)
            $accessTokenRefreshKey = session('access_token_refresh_key');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('api.auth_token'),
            ])->get(config('api.base_url').'/token/refresh/'.$accessTokenRefreshKey);

            if ($response->successful()) {
                $data = $response->json();
                $accessToken = $data['token_key'];
                $accessTokenExpiration =  $data['expires_at']; // Set a new expiration time (adjust as needed)
                $accessTokenRefreshKey = $data['refresh_token_key'];
                // Update the session with the new access token and expiration time
                session(['access_token' => $accessToken, 'access_token_expires_at' => $accessTokenExpiration, 'access_token_refresh_key' => $accessTokenRefreshKey]);
                return $next($request);
            } else {
                // Handle token regeneration error
                return $next($request);
            }
        }

        return $next($request);
    }
}
