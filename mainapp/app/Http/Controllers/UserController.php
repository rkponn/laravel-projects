<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Register Method
    public function store(Request $request): RedirectResponse
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        // store into db
        $user = User::create($incomingFields);
        // send the cookie session so user is logged in auto after registering
        auth()->login($user);

        return redirect(route('home.index'))->with('success', "Thank You $user->username, You have successfully registered.");
    }
}
