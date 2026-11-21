<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // only places of public trips count
        $isPublic = fn ($query) => $query->where('is_public', true);

        $categories = Category::query()
            ->whereHas('places.trip', $isPublic)
            ->withCount(['places' => fn ($query) => $query->whereHas('trip', $isPublic)])
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(int $id)
    {
        $isPublic = fn ($query) => $query->where('is_public', true);

        $category = Category::query()
            ->whereHas('places.trip', $isPublic)
            ->findOrFail($id);

        $places = $category->places()
            ->whereHas('trip', $isPublic)
            ->orderBy('name')
            ->get();

        return view('categories.show', compact('category', 'places'));
    }
}
