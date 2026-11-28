<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Models\Category;
use App\Models\Place;
use App\Models\Trip;
use Illuminate\Support\Arr;

class PlaceController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            // an admin sees the places of everybody
            $places = Place::query()
                ->with(['trip.user', 'categories'])
                ->orderBy('name')
                ->get();
        } else {
            // the places of the trips of the logged-in user
            $places = Place::query()
                ->with(['trip.user', 'categories'])
                ->whereHas('trip', fn ($query) => $query->where('user_id', auth()->user()->id))
                ->orderBy('name')
                ->get();
        }

        return view('userzone.places.index', compact('places'));
    }

    public function create()
    {
        // this returns only view
        return view('userzone.places.create', [
            'tripOptions' => $this->tripOptions(),
            'categoryOptions' => $this->categoryOptions(),
        ]);
    }

    public function store(PlaceRequest $request)
    {

        // methods for managing many-to-many relationships through a pivot table
        //    attach() - adds connections, keep existing ones
        //    sync()   - makes connections exactly as provided in the args. e.g. sync([2,3])
        //    detach() - removes all connections

        // PlaceRequest has already validated the data before this method runs
        $validated = $request->validated();

        $this->abortUnlessAllowedToUseTrip($validated['trip_id']);

        // "categories" and "photo" are not columns of places table
        // when creating the place, remove them from the validated array
        $place = Place::create(Arr::except($validated, ['categories', 'photo']));

        $place->categories()->sync($validated['categories'] ?? []);

        if ($request->hasFile('photo')) {
            $place->addMediaFromRequest('photo')->toMediaCollection('photos');
        }

        return redirect()->route('userzone.places.index');
    }

    public function edit(int $id)
    {
        $place = Place::findOrFail($id);

        abort_unless($place->canManage(auth()->user()), 403);

        return view('userzone.places.edit', [
            'place' => $place,
            'tripOptions' => $this->tripOptions(),
            'categoryOptions' => $this->categoryOptions(),
        ]);
    }

    public function update(PlaceRequest $request, int $id)
    {
        // PlaceRequest has already validated the data before this method runs
        $validated = $request->validated();

        $place = Place::findOrFail($id);

        abort_unless($place->canManage(auth()->user()), 403);

        // the place may only be moved to a trip the user may manage
        $this->abortUnlessAllowedToUseTrip($validated['trip_id']);

        $place->update(Arr::except($validated, ['categories', 'photo']));

        // sync also removes the categories that were unticked
        $place->categories()->sync($validated['categories'] ?? []);

        // only when a new photo was chosen (otherwise the current photo stays)
        if ($request->hasFile('photo')) {
            $place->addMediaFromRequest('photo')->toMediaCollection('photos');
        }

        return redirect()->route('userzone.places.index');
    }

    public function destroy(int $id)
    {
        $place = Place::findOrFail($id);

        abort_unless($place->canManage(auth()->user()), 403);

        // pure foreign keys: remove the category links ourselves
        $place->categories()->detach();

        $place->delete();

        return redirect()->route('userzone.places.index');
    }

    /**
     * A place may only be added to (or moved to) a trip that the user may manage.
     */
    private function abortUnlessAllowedToUseTrip(int $tripId): void
    {
        $trip = Trip::findOrFail($tripId);

        abort_unless($trip->canManage(auth()->user()), 403);
    }

    /**
     * The trips the logged-in user may use, as options for a select.
     *
     * @return array<int, array{key: int, value: string}>
     */
    private function tripOptions(): array
    {
        $trips = auth()->user()->is_admin
            ? Trip::query()->orderBy('title')->get()
            : Trip::query()->where('user_id', auth()->user()->id)->orderBy('title')->get();

        return $trips
            ->map(fn (Trip $trip) => [
                'key' => $trip->id,
                'value' => $trip->title,
            ])
            ->all();
    }

    /**
     * @return array<int, array{key: int, value: string}>
     */
    private function categoryOptions(): array
    {
        return Category::query()
            ->orderBy('name')
            ->get()
            ->map(fn (Category $category) => [
                'key' => $category->id,
                'value' => $category->name,
            ])
            ->all();
    }
}
