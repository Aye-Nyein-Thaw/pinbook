<x-site-layout :title="$category->name">

    <h1 class="text-3xl font-bold tracking-tight text-teal-800">{{ $category->name }}</h1>

    <div class="mt-6 divide-y divide-teal-100 border-t border-teal-100">
        @foreach($places as $place)
            <div class="py-4">
                <h2 class="text-lg font-semibold">
                    <a href="{{ route('places.show', $place->id) }}" class="text-teal-700 hover:underline">{{ $place->name }}</a>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $place->visited_on }}
                    &middot;
                    Trip: <a href="{{ route('trips.show', $place->trip->id) }}" class="text-teal-700 hover:underline">{{ $place->trip->title }}</a>
                </p>
            </div>
        @endforeach
    </div>

    <p class="mt-8"><a href="{{ route('categories.index') }}" class="font-medium text-teal-700 hover:underline">Back to all categories</a></p>

</x-site-layout>
