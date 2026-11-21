<x-site-layout :title="$category->name">

    <h1>{{ $category->name }}</h1>

    @foreach($places as $place)
        <div>
            <h2><a href="{{ route('places.show', $place->id) }}">{{ $place->name }}</a></h2>
            <p>
                {{ $place->visited_on }}
                &middot;
                Trip: <a href="{{ route('trips.show', $place->trip->id) }}">{{ $place->trip->title }}</a>
            </p>
        </div>
        <hr/>
    @endforeach

    <p><a href="{{ route('categories.index') }}">Back to all categories</a></p>

</x-site-layout>
