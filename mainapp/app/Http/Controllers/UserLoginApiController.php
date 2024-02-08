<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserLoginApiController extends Controller
{
    // login
    public function create(Request $request): JsonResponse
    {
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // if attempt of username and password return 200 else return 401
        if (auth()->attempt($incomingFields)) {
            $user = User::where('username', $incomingFields['username'])->first();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid login!!',
            ], 401);
        }
    }
}
