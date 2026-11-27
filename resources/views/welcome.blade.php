<x-site-layout title="">

    <h1 class="text-4xl font-bold tracking-tight text-teal-800">Pinbook</h1>

    <p class="mt-3 max-w-2xl text-lg text-slate-600">Write your trips as a series of stops, and keep the stories of the places you visited.</p>

    <h2 class="mt-10 text-2xl font-semibold text-slate-900">Latest trips</h2>

    <div class="mt-4 divide-y divide-teal-100 border-t border-teal-100">
        @foreach($trips as $trip)
            <div class="py-5">
                <h3 class="text-lg font-semibold">
                    <a href="{{ route('trips.show', $trip['id']) }}" class="text-teal-700 hover:underline">{{ $trip['title'] }}</a>
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $trip['destination'] }}
                    &middot;
                    {{ $trip['start_date'] }} - {{ $trip['end_date'] }}
                    &middot;
                    by {{ $trip['owner'] }}
                </p>
            </div>
        @endforeach
    </div>

    <p class="mt-6"><a href="{{ route('trips.index') }}" class="font-medium text-teal-700 hover:underline">See all trips</a></p>

</x-site-layout>
