<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PlaceController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            // an admin sees the places of everybody
            $places = Place::query()
                ->orderBy('name')
                ->get();
        } else {
            // the places of the trips of the logged-in user
            $places = Place::query()
                ->whereHas('trip', fn ($query) => $query->where('user_id', auth()->user()->id))
                ->orderBy('name')
                ->get();
        }

        return view('userzone.places.index', compact('places'));
    }

    public function create()
    {
        return view('userzone.places.create', [
            'tripOptions' => $this->tripOptions(),
            'categoryOptions' => $this->categoryOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        $this->abortUnlessAllowedToUseTrip($validated['trip_id']);

        // "categories" is not a column of places: it belongs in the pivot table
        $place = Place::create(Arr::except($validated, ['categories']));

        $place->categories()->sync($validated['categories'] ?? []);

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

    public function update(Request $request, int $id)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        $place = Place::findOrFail($id);

        abort_unless($place->canManage(auth()->user()), 403);

        // the place may only be moved to a trip the user may manage
        $this->abortUnlessAllowedToUseTrip($validated['trip_id']);

        $place->update(Arr::except($validated, ['categories']));

        // sync also removes the categories that were unticked
        $place->categories()->sync($validated['categories'] ?? []);

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
     * @return array<string, array<int, string>>
     */
    private function validationRules(): array
    {
        return [
            'trip_id' => ['required', 'exists:trips,id'],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'story' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'visited_on' => ['required', 'date'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function validationMessages(): array
    {
        return [
            'trip_id.required' => 'Please choose the trip of this place.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
        ];
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
