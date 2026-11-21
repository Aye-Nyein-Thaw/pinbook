<?php

namespace App\Http\Controllers;

use App\Models\Place;

class PlaceController extends Controller
{
    public function show(int $id)
    {
        $place = Place::findOrFail($id);

        abort_unless($place->trip->is_public, 404);

        return view('places.show', compact('place'));
    }
}
