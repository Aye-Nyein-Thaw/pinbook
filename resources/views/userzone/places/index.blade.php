<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My places
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">The places of your trips</h3>

                    <a href="{{ route('userzone.places.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                        New place
                    </a>
                </div>

                <table class="w-full text-left text-sm text-gray-900">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Name</th>
                            <th scope="col" class="px-6 py-3 font-medium">Trip</th>
                            <th scope="col" class="px-6 py-3 font-medium">Visited on</th>
                            <th scope="col" class="px-6 py-3 font-medium">Categories</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($places as $place)
                            <tr>
                                <td class="px-6 py-4">{{ $place->name }}</td>
                                <td class="px-6 py-4">{{ $place->trip->title }}</td>
                                <td class="px-6 py-4">{{ $place->visited_on }}</td>
                                <td class="px-6 py-4">
                                    @foreach($place->categories as $category)
                                        <span class="rounded-full bg-gray-100 px-3 py-0.5 text-xs font-medium text-gray-700">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">None of your trips has places yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
