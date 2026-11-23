<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comment on {{ $comment->trip->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p class="text-sm text-gray-500">
                        Written by {{ $comment->user->name }} on {{ $comment->created_at->format('Y-m-d H:i') }}
                    </p>

                    <p class="whitespace-pre-line">{{ $comment->content }}</p>

                    <p class="text-sm">
                        Status:
                        @if($comment->approved_at)
                            approved on {{ $comment->approved_at->format('Y-m-d H:i') }}
                        @else
                            waiting for approval
                        @endif
                    </p>

                    <hr/>

                    <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-widest">
                        <a href="{{ route('userzone.comments.edit', $comment->id) }}" class="text-gray-800 hover:text-gray-600">Edit</a>
                        <a href="{{ route('userzone.comments.index') }}" class="text-gray-800 hover:text-gray-600">Back to the list</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
