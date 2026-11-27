<x-site-layout :title="$trip->title">

    <h1 class="page-title">{{ $trip->title }}</h1>

    <p class="muted mt-3 flex flex-wrap items-center gap-3 text-sm">
        <span class="stamp">{{ $trip->start_date }} - {{ $trip->end_date }}</span>
        <span>{{ $trip->destination }} &middot; by {{ $trip->user->name }}</span>
    </p>

    <p class="mt-6 max-w-3xl whitespace-pre-line leading-7 ">{{ $trip->description }}</p>

    <h2 class="section-title mt-10">Places</h2>

    <div class="route mt-5 space-y-6">
        @forelse($places as $place)
            <div class="stop card flex flex-col gap-5 sm:flex-row">
                <img src="{{ $place->getPhotoUrl('thumbnail') }}" alt="{{ $place->name }}" class="polaroid w-48 self-start">
                <div>
                <h3 class="card-title">
                    <a href="{{ route('places.show', $place->id) }}" class="link">{{ $place->name }}</a>
                </h3>
                <p class="muted mt-1 text-sm">{{ $place->visited_on }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($place->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                    @endforeach
                </div>
                <p class="mt-3 max-w-3xl whitespace-pre-line text-sm leading-6 ">{{ $place->story }}</p>
                </div>
            </div>
        @empty
            <p class="py-4 text-sm text-slate-500">No places yet.</p>
        @endforelse
    </div>

    <h2 class="section-title mt-10">Comments ({{ $comments->count() }})</h2>

    <x-trip-comment-form :trip="$trip" />

    <div class="mt-4 max-w-3xl space-y-3">
        @forelse($comments as $comment)
            <div class="card">
                <strong class="text-sm">{{ $comment->user->name }}</strong>

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

    <p class="mt-8"><a href="{{ route('trips.index') }}" class="font-medium link">Back to all trips</a></p>

</x-site-layout>
