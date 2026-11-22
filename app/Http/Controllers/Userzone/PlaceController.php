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
        // the places of the trips of the logged-in user
        $places = Place::query()
            ->whereHas('trip', fn ($query) => $query->where('user_id', auth()->user()->id))
            ->orderBy('name')
            ->get();

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

        // "categories" is not a column of places: it belongs in the pivot table
        $place = Place::create(Arr::except($validated, ['categories']));

        $place->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('userzone.places.index');
    }

    public function edit(int $id)
    {
        $place = Place::findOrFail($id);

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

        $place->update(Arr::except($validated, ['categories']));

        // sync also removes the categories that were unticked
        $place->categories()->sync($validated['categories'] ?? []);

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
     * The trips of the logged-in user, as options for a select.
     *
     * @return array<int, array{key: int, value: string}>
     */
    private function tripOptions(): array
    {
        return Trip::query()
            ->where('user_id', auth()->user()->id)
            ->orderBy('title')
            ->get()
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
