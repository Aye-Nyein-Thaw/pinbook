<x-site-layout title="">

    <section class="hero px-8 py-20 text-center">
        <h1>Pinbook</h1>

        <p class="mx-auto mt-3 max-w-2xl text-lg">Write your trips as a series of stops, and keep the stories of the places you visited.</p>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('trips.index') }}" class="btn">See all trips</a>
            @guest
                <a href="{{ route('register') }}" class="btn-light">Start your journal</a>
            @endguest
        </div>

        <p class="photo-credit mt-10">Photo: Tre Cime di Lavaredo by Tiia Monto, CC BY-SA 3.0, Wikimedia Commons</p>
    </section>

    <h2 class="section-title mt-12">Latest trips</h2>

    <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($trips as $trip)
            <a href="{{ route('trips.show', $trip['id']) }}" class="card block">
                <span class="stamp">{{ $trip['start_date'] }} - {{ $trip['end_date'] }}</span>
                <h3 class="card-title mt-4">{{ $trip['title'] }}</h3>
                <p class="muted mt-1 text-sm">{{ $trip['destination'] }} &middot; by {{ $trip['owner'] }}</p>
            </a>
        @endforeach
    </div>

</x-site-layout>
