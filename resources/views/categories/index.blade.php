<x-site-layout title="Categories">

    <h1 class="text-3xl font-bold tracking-tight text-teal-800">Categories</h1>

    <div class="mt-6 divide-y divide-teal-100 border-t border-teal-100">
        @foreach($categories as $category)
            <div class="flex items-center justify-between py-4">
                <h2 class="text-lg font-semibold">
                    <a href="{{ route('categories.show', $category->id) }}" class="text-teal-700 hover:underline">{{ $category->name }}</a>
                </h2>
                <p class="text-sm text-slate-500">{{ $category->places_count }} {{ Str::plural('place', $category->places_count) }}</p>
            </div>
        @endforeach
    </div>

</x-site-layout>
