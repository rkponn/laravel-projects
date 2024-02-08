<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AvatarController extends Controller
{
    // Avatar form
    public function create(): \Illuminate\View\View
    {
        return view('avatar-form');
    }

    // Store the avatar
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // save the avatar
        $request->validate([
            'avatar' => 'required|image|max:5000',
        ]);
        $user = auth()->user();

        // give the avatar file/image a unique name.
        $filename = $user->id.'-'.uniqid().'.jpg';
        // make image certain size and type from request that we imported in file
        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/'.$filename, $imgData);

        // grab old avatar name to prevent storing more than 1 per user
        $oldAvatar = $user->avatar;

        // save to the database
        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != '/fallback-avatar.jpg') {
            // Filepath needs to be tweaked
            Storage::delete(str_replace('/storage/', 'public/', $oldAvatar));
        }

        return back()->with('success', 'New avatar uploaded.');
    }
}
