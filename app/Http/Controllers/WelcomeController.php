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
        $trips = Trip::query()
            ->where('is_public', true)
            ->orderByDesc('start_date')
            ->take(6)
            ->get();

        return view('welcome', compact('trips'));
    }
}

// when a controller has an __invoke() method, Laravel can use the controller as a single-action controller.
// Instead of having several methods such as index(), show(), and create(), this controller has one main action: display the homepage.
// where(), orderbydesc(), take() build the query. get() retrieves the results
