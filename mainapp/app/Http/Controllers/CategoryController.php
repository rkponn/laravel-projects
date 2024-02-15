<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Display the specified category.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Remove the specified category from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Detach the category from any posts it's related to
        $category->posts()->detach();

        // Delete the category
        $category->delete();

        // Redirect back with a success message
        return back()->with('success', 'Category successfully deleted.');
    }
}
