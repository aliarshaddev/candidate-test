<?php

namespace App\Http\Controllers;

use App\Services\CustomAuthService;
use Illuminate\Http\Request;
use Auth;
use Session;

class AuthController extends Controller
{
    protected $customAuthService;

    public function __construct(CustomAuthService $customAuthService)
    {
        $this->customAuthService = $customAuthService;
    }
    private function validateLoginData()
    {
        $request = Request();
        return $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
    }
    public function loginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $data = $this->validateLoginData();
        $email = $data['email'];
        $password = $data['password'];
        if ($this->customAuthService->login($email, $password)) {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // Authentication successful
                return redirect()->route('dashboard'); // Redirect to the authenticated user's dashboard
            }
            // Authentication failed
            return back()->withErrors(['email' => 'Login failed.']);
        } else {
            return back()->withErrors(['email' => 'Login failed.']);
        }
    }
    public function logout()
    {
        // Clear all session data
        Session::flush();
        Auth::logout();
        return redirect()->route('login'); // Redirect to the login page
    }
}

