<x-site-layout title="Categories">

    <h1>Categories</h1>

    @foreach($categories as $category)
        <div>
            <h2><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></h2>
            <p>{{ $category->places_count }} {{ Str::plural('place', $category->places_count) }}</p>
        </div>
        <hr/>
    @endforeach

</x-site-layout>
