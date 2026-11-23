<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::query()
            ->where('is_public', true)
            ->orderByDesc('start_date')
            ->get();

        return view('trips.index', compact('trips'));
    }

    public function show(int $id)
    {
        $trip = Trip::query()
            ->where('is_public', true)
            ->findOrFail($id);

        $places = $trip->places()->orderBy('visited_on')->get();

        // the newest comments first, and only the ones this visitor may see
        $comments = $trip->visibleCommentsFor(auth()->user());

        return view('trips.show', compact('trip', 'places', 'comments'));
    }
}
