<x-site-layout title="Trips">

    <h1 class="page-title">Trips</h1>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($trips as $trip)
            <a href="{{ route('trips.show', $trip->id) }}" class="card block">
                <span class="stamp">{{ $trip->start_date }} - {{ $trip->end_date }}</span>
                <h2 class="card-title mt-4">{{ $trip->title }}</h2>
                <p class="muted mt-1 text-sm">{{ $trip->destination }} &middot; by {{ $trip->user->name }}</p>
            </a>
        @endforeach
    </div>

</x-site-layout>
