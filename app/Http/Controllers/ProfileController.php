<?php

namespace App\Http\Controllers;

use App\Clients\ApiClient;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    protected $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
    public function showProfile()
    {
        $response = $this->apiClient->getMyProfile();
        if ($response->successful()) {
            $data = $response->json();
            return view('profile', ['profile' => $data]);
        } else {
            return redirect()->back()->with('error', 'There was an error.');
        }
       
    }
}
