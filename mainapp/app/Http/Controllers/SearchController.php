<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    // Search for posts, tags, users, and categories
    public function index($term): Collection
    {
        // Performs a search for posts based on term and returns a collection of posts with user information
        $postIds = Post::search($term)->keys();

        // Performs a search for tags based on term and returns a collection of tag IDs
        $tagIds = Tag::search($term)->keys();

        // Performs a search for users based on term and returns a collection of user IDs
        $userIds = User::search($term)->keys();

        // Performs a search for categories based on term and returns a collection of category IDs
        $categoryIds = Category::search($term)->keys();

        return Post::whereIn('id', $postIds)
            ->orWhereIn('user_id', $userIds)
            ->orWhereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            })
            ->orWhereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->with('user:id,username,avatar', 'tags:id,name,slug', 'categories:id,name')
            ->get();
    }
}
