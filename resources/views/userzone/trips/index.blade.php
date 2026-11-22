<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My trips
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Hello {{ auth()->user()->name }}, these are your trips</h3>
                </div>

                <table class="w-full text-left text-sm text-gray-900">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Title</th>
                            <th scope="col" class="px-6 py-3 font-medium">Destination</th>
                            <th scope="col" class="px-6 py-3 font-medium">Dates</th>
                            <th scope="col" class="px-6 py-3 font-medium">Visibility</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($trips as $trip)
                            <tr>
                                <td class="px-6 py-4">{{ $trip->title }}</td>
                                <td class="px-6 py-4">{{ $trip->destination }}</td>
                                <td class="px-6 py-4">{{ $trip->start_date }} - {{ $trip->end_date }}</td>
                                <td class="px-6 py-4">{{ $trip->is_public ? 'Public' : 'Private' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">You have no trips yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
