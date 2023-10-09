<?php
namespace App\Services;

use App\Client\ApiClient;
use Illuminate\Support\Facades\Http;
class CustomAuthService
{
    protected $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
    public function loginViaSession($email, $password)
    {
        if(session()->has('access_token'))
        {
            $accessTokenExpiration = session('access_token_expires_at');
            // Check if the access token has expired
            if (now()->gte($accessTokenExpiration)) {
                // Regenerate the token (make a request to your API to get a new token)
                $accessTokenRefreshKey = session('access_token_refresh_key');
                $response = $this->apiClient->refreshToken($accessTokenRefreshKey);
                dd($response);
                if ($response->successful()) {
                    $data = $response->json();
                    session(['access_token' => $data['token_key'], 'access_token_expires_at' => $data['expires_at'], 'access_token_refresh_key' => $data['refresh_token_key'], 'user' => $data['user']]);
                    return true;
                } else {
                    // Handle token regeneration error
                    return false;
                }
            }
            else
            {
                return true;
            }
        }
        else
        {
            $data = $this->getToken($email, $password);
            if($data)
            {
                session(['access_token' => $data['token_key'], 'access_token_expires_at' => $data['expires_at'], 'access_token_refresh_key' => $data['refresh_token_key'], 'user' => $data['user']]);
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
        $response = $this->apiClient->getApiToken($email, $password);
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }
        else
        {
            return false;
        }
    }
}
