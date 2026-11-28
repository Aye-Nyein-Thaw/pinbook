<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Models\Trip;

class TripController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            // an admin sees the trips of everybody
            $trips = Trip::query()
                ->with('user')
                ->orderByDesc('start_date')
                ->get();
        } else {
            $trips = Trip::query()
                ->with('user')
                ->where('user_id', auth()->user()->id)
                ->orderByDesc('start_date')
                ->get();
        }

        return view('userzone.trips.index', compact('trips'));
    }

    public function create()
    {
        // displays the new trip creation form
        // Only displays the form. Does not edit anything

        return view('userzone.trips.create', [
            'visibilityOptions' => $this->visibilityOptions(),
        ]);
    }

    public function store(TripRequest $request)
    {
        // saves a new trip. creates a new record in the database

        // TripRequest has already validated the data before this method runs
        $validated = $request->validated();

        // the trip belongs to the logged-in user, never to a value sent by the form (for security)
        $validated['user_id'] = auth()->user()->id;

        Trip::create($validated);

        return redirect()->route('userzone.trips.index');
    }

    public function edit(int $id)
    {
        // display the edit form

        $trip = Trip::findOrFail($id);

        abort_unless($trip->canManage(auth()->user()), 403);

        return view('userzone.trips.edit', [
            'trip' => $trip,
            'visibilityOptions' => $this->visibilityOptions(),
        ]);
    }

    public function update(TripRequest $request, int $id)
    {
        // save changes to a trip

        // TripRequest has already validated the data before this method runs
        $validated = $request->validated();

        $trip = Trip::findOrFail($id);

        abort_unless($trip->canManage(auth()->user()), 403);

        // the owner (user_id) is not in $validated, so it never changes here
        $trip->update($validated);

        return redirect()->route('userzone.trips.index');
    }

    public function destroy(int $id)
    {
        // deletes a trip

        $trip = Trip::findOrFail($id);

        abort_unless($trip->canManage(auth()->user()), 403);

        // our foreign keys are pure (no cascades), so we clean up ourselves:
        // each place loses its category links and is deleted as a model, so that
        // its photo is removed as well; then the comments
        // detach() removes pivot table links -> then, delete the place
        foreach ($trip->places as $place) {
            $place->categories()->detach();
            $place->delete();
        }

        // delete the trip's comment
        $trip->comments()->delete();

        // delete the trip
        $trip->delete();

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
