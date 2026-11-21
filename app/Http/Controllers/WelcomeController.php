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
        $trips = Trip::query()
            ->where('is_public', true)
            ->orderByDesc('start_date')
            ->take(6)
            ->get();

        return view('welcome', compact('trips'));
    }
}
