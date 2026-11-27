<div id="comments">
    @auth
        <form action="{{ route('trips.comments.store', $trip->id) }}" method="post" class="mt-4 max-w-xl">
            @csrf

            <p class="mb-2 text-sm text-slate-500">You are {{ auth()->user()->name }}</p>

            <x-form-textarea name="content" label="Your comment" placeholder="Leave a comment" rows="4" required/>

            <button type="submit" class="btn mt-3">Post comment</button>
        </form>
    @else
        <p class="card mt-4 max-w-xl text-sm">
            You need to be logged in to make a comment.
            <a href="{{ route('login', ['redirect' => request()->getRequestUri().'#comments']) }}" class="link">Log in</a>
        </p>
    @endauth
</div>
