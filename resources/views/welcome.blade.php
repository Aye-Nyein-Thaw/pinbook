<x-site-layout title="">

    <h1>Pinbook</h1>

    <p>Write your trips as a series of stops, and keep the stories of the places you visited.</p>

    <h2>Latest trips</h2>

    @foreach($trips as $trip)
        <div>
            <h3><a href="{{ route('trips.show', $trip->id) }}">{{ $trip->title }}</a></h3>
            <p>
                {{ $trip->destination }}
                &middot;
                {{ $trip->start_date }} - {{ $trip->end_date }}
                &middot;
                by {{ $trip->user->name }}
            </p>
        </div>
        <hr/>
    @endforeach

    <p><a href="{{ route('trips.index') }}">See all trips</a></p>

</x-site-layout>
