<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // display all the tags
        return Tag::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        // display a single tag
        return $tag;
    }
}