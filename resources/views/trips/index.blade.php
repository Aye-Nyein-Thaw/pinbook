<x-site-layout title="Trips">

    <h1>Trips</h1>

    @foreach($trips as $trip)
        <div>
            <h2><a href="{{ route('trips.show', $trip->id) }}">{{ $trip->title }}</a></h2>
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

</x-site-layout>
