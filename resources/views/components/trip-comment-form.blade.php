<div id="comments">
    @auth
        <form action="{{ route('trips.comments.store', $trip->id) }}" method="post" class="mt-4 max-w-xl">
            @csrf

            <p class="mb-2 text-sm text-slate-500">You are {{ auth()->user()->name }}</p>

            <x-form-textarea name="content" label="Your comment" placeholder="Leave a comment" rows="4" required/>

            <button type="submit" class="mt-3 rounded-md bg-teal-600 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700">Post comment</button>
        </form>
    @else
        <p class="mt-4 rounded-md bg-amber-100 px-4 py-2 text-sm text-slate-700">
            You need to be logged in to make a comment.
            <a href="{{ route('login', ['redirect' => request()->getRequestUri().'#comments']) }}" class="font-medium text-teal-700 hover:underline">Log in</a>
        </p>
    @endauth
</div>
