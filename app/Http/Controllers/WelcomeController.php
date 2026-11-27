<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // get only public trips using query()
        // keep the result for 10 seconds: only the first visitor runs the queries
        // only public trips are cached, they look the same for everybody
        $trips = cache()->remember('latest_trips', 10, function () {
            return Trip::query()
                ->with('user')
                ->where('is_public', true)
                ->orderByDesc('start_date')
                ->take(6)
                ->get()
                // cache simple arrays, not model objects (config/cache.php does not allow objects)
                ->map(fn (Trip $trip) => [
                    'id' => $trip->id,
                    'title' => $trip->title,
                    'destination' => $trip->destination,
                    'start_date' => $trip->start_date,
                    'end_date' => $trip->end_date,
                    'owner' => $trip->user->name,
                ])
                ->all();
        });

        return view('welcome', compact('trips'));
    }
}

// when a controller has an __invoke() method, Laravel can use the controller as a single-action controller.
// Instead of having several methods such as index(), show(), and create(), this controller has one main action: display the homepage.
// where(), orderbydesc(), take() build the query. get() retrieves the results
