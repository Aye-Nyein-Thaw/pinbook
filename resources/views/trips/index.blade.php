<x-site-layout title="Trips">

    <h1 class="text-3xl font-bold tracking-tight text-teal-800">Trips</h1>

    <div class="mt-6 divide-y divide-teal-100 border-t border-teal-100">
        @foreach($trips as $trip)
            <div class="py-5">
                <h2 class="text-lg font-semibold">
                    <a href="{{ route('trips.show', $trip->id) }}" class="text-teal-700 hover:underline">{{ $trip->title }}</a>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $trip->destination }}
                    &middot;
                    {{ $trip->start_date }} - {{ $trip->end_date }}
                    &middot;
                    by {{ $trip->user->name }}
                </p>
            </div>
        @endforeach
    </div>

</x-site-layout>
