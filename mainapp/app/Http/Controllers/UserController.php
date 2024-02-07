<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // method should be called index
    public function homepage() {
        // globally available auth - if logged in or not
        if(auth()->check()) {
            return view('homepage-feed', [
                'posts' => auth()->user()->feedPost()->latest()->paginate(10),
                'username' => auth()->user()->username,
                ]);
        } else {
            // cached data - prevent multiple calls
            $postCount = Cache::remember('postCount', 20, function() {
                return Post::count();
            });
            return view('homepage', ['postCount' => $postCount]);
        }
    }

    // method should be called store
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

    // login method should be moved to a separate controller UserLoginController and called store
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

    // login method should be moved to a separate controller UserLoginController and called delete
    public function logout() {
        // access auth class -> logout method
        auth()->logout();
        return redirect('/')->with('success', 'You have logged out.');
    }

    // method should be in a separate controller and called create
    public function showAvatarForm() {
        return view('avatar-form');
    }

    // method should be in a separate controller and called store
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

    // method should be in a separate controller and called store
    // API related
    public function loginApi(Request $request) {
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // if attempt of username and password return 200 else return 401
        if(auth()->attempt($incomingFields)) {
            $user = User::where('username', $incomingFields['username'])->first();
            $token = $user->createToken('token-name')->plainTextToken;
            return $token;
        } else {
            return response()->json([
                'message' => 'Invalid login!!'
            ], 401);
        }
    }

}
