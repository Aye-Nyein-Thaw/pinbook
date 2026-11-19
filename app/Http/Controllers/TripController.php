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
}
