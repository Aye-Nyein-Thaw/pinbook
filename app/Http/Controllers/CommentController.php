<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Trip;
use App\Notifications\NewCommentOnYourTripNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, int $tripId)
    {
        // step 0 - validation
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'content.min' => 'Your comment needs at least 3 characters.',
        ]);

        // step 1 - load the necessary data (comments are only possible on public trips)
        $trip = Trip::query()
            ->where('is_public', true)
            ->findOrFail($tripId);

        // step 2 - create the comment (the writer is the logged-in user, set here, not in the form)
        $comment = Comment::create([
            'trip_id' => $trip->id,
            'user_id' => auth()->user()->id,
            'content' => $validated['content'],
        ]);

        // tell the owner of the trip, but not when they comment on their own trip
        if ($trip->user_id != auth()->user()->id) {
            $trip->user->notify(new NewCommentOnYourTripNotification($comment));
        }

        // step 3 - return a response: back to the page where the form was
        return redirect()->back();
    }
}
