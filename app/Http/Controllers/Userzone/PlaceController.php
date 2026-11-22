<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index()
    {
        // the places of the trips of the logged-in user
        $places = Place::query()
            ->whereHas('trip', fn ($query) => $query->where('user_id', auth()->user()->id))
            ->orderBy('name')
            ->get();

        return view('userzone.places.index', compact('places'));
    }
}
