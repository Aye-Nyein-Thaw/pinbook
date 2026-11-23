<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit the comment on {{ $comment->trip->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <p class="mb-4 text-sm text-gray-500">Written by {{ $comment->user->name }}</p>

                    <form action="{{ route('userzone.comments.update', $comment->id) }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="space-y-4">
                            <x-form-textarea name="content" label="Comment" placeholder="The comment" rows="4" :value="$comment->content" required/>

                            <x-form-select name="approved" label="Status" :options="$approvalOptions" :value="$comment->approved_at ? 1 : 0" placeholder="Approved or not?" required/>
                        </div>

                        <hr class="my-4"/>

                        <button type="submit" class="p-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">Update comment</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
