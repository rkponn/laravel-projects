<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function create(Request $request): \Illuminate\Http\Response {
        // Need to have a message before we send request
        $formFields = $request->validate([
            'textvalue' => 'required'
        ]);

        // remove white space and any tags
        if(!trim(strip_tags($formFields['textvalue']))) {
            // global resposne function.
            return response()->noContent();
        }
        // if formFields is valid
        broadcast(new ChatMessage(
            [
                'username' => auth()->user()->username,
                'textvalue' => strip_tags($request->textvalue),
                'avatar' => auth()->user()->avatar
            ], 
            ))->toOthers();
        return response()->noContent();
    }
}
