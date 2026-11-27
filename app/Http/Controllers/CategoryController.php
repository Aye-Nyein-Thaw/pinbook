<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // only places of public trips count
        // isPublic is a function
        $isPublic = fn ($query) => $query->where('is_public', true);

        // load categories that have at least one place belonging to a public trip
        $categories = Category::query()
            ->whereHas('places.trip', $isPublic)
            ->withCount(['places' => fn ($query) => $query->whereHas('trip', $isPublic)])
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(int $id)
    {
        // function to filter rows with "is_public" column = True
        $isPublic = fn ($query) => $query->where('is_public', true);

        // find category from a list of categories (of public trips)
        $category = Category::query()
            ->whereHas('places.trip', $isPublic)
            ->findOrFail($id);

        // find places belonging to one category
        $places = $category->places()
            ->with('trip')
            ->whereHas('trip', $isPublic)
            ->orderBy('name')
            ->get();

        return view('categories.show', compact('category', 'places'));
    }
}

// whereHas() filters categories based on whether related records exist that satisfy a condition
// with('places')       - The actual related places
// withCount('places')  - The number of related places
