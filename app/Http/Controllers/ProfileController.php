<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/me');
        if ($response->successful()) {
            $data = $response->json();
            return view('profile', ['profile' => $data]);
        } else {
            return redirect()->back()->with('error', 'There was an error.');
        }
       
    }
}
