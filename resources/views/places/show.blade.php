<x-site-layout :title="$place->name">

    <h1 class="text-3xl font-bold tracking-tight text-teal-800">{{ $place->name }}</h1>

    <p class="mt-2 text-sm text-slate-500">
        Visited on {{ $place->visited_on }}
        &middot;
        Trip: <a href="{{ route('trips.show', $place->trip->id) }}" class="text-teal-700 hover:underline">{{ $place->trip->title }}</a>
    </p>

    <div class="mt-4 flex flex-wrap gap-2">
        @foreach($place->categories as $category)
            <span class="rounded-full bg-teal-100 px-3 py-0.5 text-xs font-medium text-teal-800">{{ $category->name }}</span>
        @endforeach
    </div>

    <p class="mt-6 max-w-3xl whitespace-pre-line leading-7 text-slate-700">{{ $place->story }}</p>

    <p class="mt-6 text-sm text-slate-500">Coordinates: {{ $place->latitude }}, {{ $place->longitude }}</p>

    <p class="mt-8"><a href="{{ route('trips.show', $place->trip->id) }}" class="font-medium text-teal-700 hover:underline">Back to the trip</a></p>

</x-site-layout>
