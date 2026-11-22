<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

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

    public function create()
    {
        return view('userzone.trips.create', [
            'visibilityOptions' => $this->visibilityOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string'],
            'destination' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_public' => ['required', 'boolean'],
        ], [
            'title.min' => 'The title needs at least 3 characters.',
            'end_date.after_or_equal' => 'The end date can not be before the start date.',
            'is_public.required' => 'Please choose public or private.',
        ]);

        // the trip belongs to the logged-in user, never to a value sent by the form
        $validated['user_id'] = auth()->user()->id;

        Trip::create($validated);

        return redirect()->route('userzone.trips.index');
    }

    /**
     * @return array<int, array{key: int, value: string}>
     */
    private function visibilityOptions(): array
    {
        return [
            ['key' => 1, 'value' => 'Public'],
            ['key' => 0, 'value' => 'Private'],
        ];
    }
}
