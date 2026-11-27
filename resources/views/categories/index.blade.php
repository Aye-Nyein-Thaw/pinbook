<x-site-layout title="Categories">

    <h1 class="page-title">Categories</h1>

    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($categories as $category)
            <div class="card card-hover">
                <h2 class="card-title">
                    <a href="{{ route('categories.show', $category->id) }}" class="link">{{ $category->name }}</a>
                </h2>
                <p class="muted mt-1 text-sm">{{ $category->places_count }} {{ Str::plural('place', $category->places_count) }}</p>
            </div>
        @endforeach
    </div>

</x-site-layout>
