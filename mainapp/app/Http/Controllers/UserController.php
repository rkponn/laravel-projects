<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function homepage() {
        // globally available auth - if logged in or not
        if(auth()->check()) {
            return view('homepage-feed', [
                'posts' => auth()->user()->feedPost()->latest()->paginate(4),
                'username' => auth()->user()->username,
                ]);
        } else {
            return view('homepage');
        }
    }

    public function register(Request $request) {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        // store into db
        $user = User::create($incomingFields);
        // send the cookie session so user is logged in auto after registering
        auth()->login($user);
        return redirect('/')->with('success', "Thank You $user->username, You have successfully registered.");
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        // if attempt of username and password return 200 else return 401
        if(auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have logged in.');
        } else {
            return redirect('/')->with('failure', 'Invalid login!!');
        }
    }

    public function logout() {
        // access auth class -> logout method
        auth()->logout();
        return redirect('/')->with('success', 'You have logged out.');
    }

    public function showAvatarForm() {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request) {
        // save the avatar
        $request->validate([
            'avatar' => 'required|image|max:5000'
        ]);
        $user = auth()->user();

        // give the avatar file/image a unique name.
        $filename = $user->id . '-' . uniqid() . '.jpg';
        // make image certain size and type from request that we imported in file
        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/' . $filename, $imgData);

        // grab old avatar name to prevent storing more than 1 per user
        $oldAvatar = $user->avatar;

        // save to the database
        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != "/fallback-avatar.jpg") {
            // Filepath needs to be tweaked
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }

        return back()->with('success', 'New avatar uploaded.');
    }
}
