<x-site-layout :title="$trip->title">

    <h1>{{ $trip->title }}</h1>

    <p>
        {{ $trip->destination }}
        &middot;
        {{ $trip->start_date }} - {{ $trip->end_date }}
        &middot;
        by {{ $trip->user->name }}
    </p>

    <p>{{ $trip->description }}</p>

    <h2>Places</h2>

    @forelse($places as $place)
        <div>
            <h3>{{ $place->name }}</h3>
            <p>{{ $place->visited_on }}</p>
            <div>
                @foreach($place->categories as $category)
                    <span>{{ $category->name }}</span>
                @endforeach
            </div>
            <p>{{ $place->story }}</p>
        </div>
        <hr/>
    @empty
        <p>No places yet.</p>
    @endforelse

    <h2>Comments</h2>

    @forelse($trip->comments as $comment)
        <div>
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->content }}</p>
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse

    <p><a href="{{ route('trips.index') }}">Back to all trips</a></p>

</x-site-layout>
