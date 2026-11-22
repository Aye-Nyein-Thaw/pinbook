<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Trip;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::query()
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('start_date')
            ->get();

        return view('userzone.trips.index', compact('trips'));
    }
}
