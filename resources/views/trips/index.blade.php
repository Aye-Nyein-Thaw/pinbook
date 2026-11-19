<x-site-layout title="Trips">

    <h1>Trips</h1>

    @foreach($trips as $trip)
        <div>
            <h2>{{ $trip->title }}</h2>
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
