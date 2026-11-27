<x-site-layout :title="$category->name">

    <h1 class="page-title">{{ $category->name }}</h1>

    <div class="mt-6 grid gap-5 sm:grid-cols-2">
        @foreach($places as $place)
            <div class="card card-hover">
                <h2 class="card-title">
                    <a href="{{ route('places.show', $place->id) }}" class="link">{{ $place->name }}</a>
                </h2>
                <p class="muted mt-1 text-sm">
                    {{ $place->visited_on }}
                    &middot;
                    Trip: <a href="{{ route('trips.show', $place->trip->id) }}" class="link">{{ $place->trip->title }}</a>
                </p>
            </div>
        @endforeach
    </div>

    <p class="mt-8"><a href="{{ route('categories.index') }}" class="font-medium link">Back to all categories</a></p>

</x-site-layout>
