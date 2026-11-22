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
                    <h3 class="font-semibold text-gray-900">{{ auth()->user()->is_admin ? 'The places of all trips' : 'The places of your trips' }}</h3>

                    <a href="{{ route('userzone.places.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                        New place
                    </a>
                </div>

                <table class="w-full text-left text-sm text-gray-900">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Name</th>
                            <th scope="col" class="px-6 py-3 font-medium">Trip</th>
                            @if(auth()->user()->is_admin)
                                <th scope="col" class="px-6 py-3 font-medium">Owner</th>
                            @endif
                            <th scope="col" class="px-6 py-3 font-medium">Visited on</th>
                            <th scope="col" class="px-6 py-3 font-medium">Categories</th>
                            <th scope="col" class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($places as $place)
                            <tr>
                                <td class="px-6 py-4">{{ $place->name }}</td>
                                <td class="px-6 py-4">{{ $place->trip->title }}</td>
                                @if(auth()->user()->is_admin)
                                    <td class="px-6 py-4">{{ $place->trip->user->name }}</td>
                                @endif
                                <td class="px-6 py-4">{{ $place->visited_on }}</td>
                                <td class="px-6 py-4">
                                    @foreach($place->categories as $category)
                                        <span class="rounded-full bg-gray-100 px-3 py-0.5 text-xs font-medium text-gray-700">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-widest">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('userzone.places.edit', $place->id) }}" class="text-gray-800 hover:text-gray-600">Edit</a>

                                        <form action="{{ route('userzone.places.destroy', $place->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-500">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">None of your trips has places yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
