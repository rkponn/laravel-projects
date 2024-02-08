<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    // Login method
    public function store(Request $request): RedirectResponse
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);

        // if attempt of username and password return 200 else return 401
        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();

            return redirect(route('home.index'))->with('success', 'You have logged in.');
        } else {
            return redirect(route('home.index'))->with('failure', 'Invalid login!!');
        }
    }

    // Logout method
    public function destroy(): RedirectResponse
    {
        // access auth class -> logout method
        auth()->logout();

        return redirect(route('home.index'))->with('success', 'You have logged out.');
    }
}
