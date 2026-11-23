<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comments
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Hello {{ auth()->user()->name }}, {{ auth()->user()->is_admin ? 'these are the comments on all trips' : 'these are the comments on your trips' }}</h3>

                    <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-widest">
                        @if(request()->boolean('unmoderated'))
                            <a href="{{ route('userzone.comments.index') }}" class="text-gray-800 hover:text-gray-600">Show all</a>
                        @else
                            <a href="{{ route('userzone.comments.index', ['unmoderated' => 1]) }}" class="text-gray-800 hover:text-gray-600">Only waiting for approval</a>
                        @endif
                    </div>
                </div>

                <table class="w-full text-left text-sm text-gray-900">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Comment</th>
                            <th scope="col" class="px-6 py-3 font-medium">Writer</th>
                            <th scope="col" class="px-6 py-3 font-medium">Trip</th>
                            <th scope="col" class="px-6 py-3 font-medium">Status</th>
                            <th scope="col" class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($comments as $comment)
                            <tr>
                                <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($comment->content, 60) }}</td>
                                <td class="px-6 py-4">{{ $comment->user->name }}</td>
                                <td class="px-6 py-4">{{ $comment->trip->title }}</td>
                                <td class="px-6 py-4">{{ $comment->approved_at ? 'Approved' : 'Waiting for approval' }}</td>
                                <td class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-widest">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('userzone.comments.show', $comment->id) }}" class="text-gray-800 hover:text-gray-600">View</a>
                                        <a href="{{ route('userzone.comments.edit', $comment->id) }}" class="text-gray-800 hover:text-gray-600">Edit</a>

                                        <form action="{{ route('userzone.comments.destroy', $comment->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-500">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">There are no comments to show.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
