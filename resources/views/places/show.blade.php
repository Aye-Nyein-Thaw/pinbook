<x-site-layout :title="$place->name">

    <h1 class="page-title">{{ $place->name }}</h1>

    <p class="mt-2 text-sm text-slate-500">
        Visited on {{ $place->visited_on }}
        &middot;
        Trip: <a href="{{ route('trips.show', $place->trip->id) }}" class="link">{{ $place->trip->title }}</a>
    </p>

    <img src="{{ $place->getPhotoUrl('details') }}" alt="{{ $place->name }}" class="polaroid mt-6 w-full max-w-xl">

    <div class="mt-4 flex flex-wrap gap-2">
        @foreach($place->categories as $category)
            <span class="tag">{{ $category->name }}</span>
        @endforeach
    </div>

    <p class="card mt-6 max-w-3xl whitespace-pre-line leading-7">{{ $place->story }}</p>

    <p class="mt-6 text-sm text-slate-500">Coordinates: {{ $place->latitude }}, {{ $place->longitude }}</p>

    <p class="mt-8"><a href="{{ route('trips.show', $place->trip->id) }}" class="font-medium link">Back to the trip</a></p>

</x-site-layout>
