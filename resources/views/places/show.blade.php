<x-site-layout :title="$place->name">

    <h1>{{ $place->name }}</h1>

    <p>
        Visited on {{ $place->visited_on }}
        &middot;
        Trip: <a href="{{ route('trips.show', $place->trip->id) }}">{{ $place->trip->title }}</a>
    </p>

    <div>
        @foreach($place->categories as $category)
            <span>{{ $category->name }}</span>
        @endforeach
    </div>

    <p>{{ $place->story }}</p>

    <p>Coordinates: {{ $place->latitude }}, {{ $place->longitude }}</p>

    <p><a href="{{ route('trips.show', $place->trip->id) }}">Back to the trip</a></p>

</x-site-layout>
