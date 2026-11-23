<x-site-layout :title="$trip->title">

    <h1 class="text-3xl font-bold tracking-tight text-teal-800">{{ $trip->title }}</h1>

    <p class="mt-2 text-sm text-slate-500">
        {{ $trip->destination }}
        &middot;
        {{ $trip->start_date }} - {{ $trip->end_date }}
        &middot;
        by {{ $trip->user->name }}
    </p>

    <p class="mt-6 max-w-3xl whitespace-pre-line leading-7 text-slate-700">{{ $trip->description }}</p>

    <h2 class="mt-10 text-2xl font-semibold text-slate-900">Places</h2>

    <div class="mt-4 divide-y divide-teal-100 border-t border-teal-100">
        @forelse($places as $place)
            <div class="py-5">
                <img src="{{ $place->getPhotoUrl('thumbnail') }}" alt="{{ $place->name }}" class="mb-3 w-40 rounded-md">
                <h3 class="text-lg font-semibold">
                    <a href="{{ route('places.show', $place->id) }}" class="text-teal-700 hover:underline">{{ $place->name }}</a>
                </h3>
                <p class="mt-1 text-sm text-slate-500">{{ $place->visited_on }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($place->categories as $category)
                        <span class="rounded-full bg-teal-100 px-3 py-0.5 text-xs font-medium text-teal-800">{{ $category->name }}</span>
                    @endforeach
                </div>
                <p class="mt-3 max-w-3xl whitespace-pre-line text-sm leading-6 text-slate-600">{{ $place->story }}</p>
            </div>
        @empty
            <p class="py-4 text-sm text-slate-500">No places yet.</p>
        @endforelse
    </div>

    <h2 class="mt-10 text-2xl font-semibold text-slate-900">Comments ({{ $comments->count() }})</h2>

    <x-trip-comment-form :trip="$trip" />

    <div class="mt-4 divide-y divide-teal-100 border-t border-teal-100">
        @forelse($comments as $comment)
            <div class="py-4">
                <strong class="text-sm text-slate-800">{{ $comment->user->name }}</strong>

                @if($comment->approved_at === null)
                    @if(auth()->id() === $comment->user_id)
                        <p class="mt-1 text-sm text-amber-700">This comment is awaiting validation. Only you and the owner of the trip can see it.</p>
                    @else
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-amber-600">Awaiting validation</p>
                    @endif
                @endif

                <p class="mt-1 text-sm leading-6 text-slate-600">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="py-4 text-sm text-slate-500">No comments yet.</p>
        @endforelse
    </div>

    <p class="mt-8"><a href="{{ route('trips.index') }}" class="font-medium text-teal-700 hover:underline">Back to all trips</a></p>

</x-site-layout>
