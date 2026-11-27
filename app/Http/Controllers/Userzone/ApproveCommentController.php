<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;

class ApproveCommentController extends Controller
{
    /**
     * Approve one comment (a single action, so a single-action controller).
     */
    public function __invoke(int $id): RedirectResponse
    {
        $comment = Comment::findOrFail($id);

        // checks whether current logged-in user is allowed to manage this comment, if not --> return 403
        abort_unless($comment->canManage(auth()->user()), 403);

        // approving twice keeps the first approval date --> why twice ? someone might click the approval button twice, refresh, or submit the same request again.
        // approved_at ?? checks if that column value is NULL
        // if not NULL, use it,   if NULL, use value on the right "now()"
        // now() returns current date and time
        // updates "approved_at" column
        $comment->update(['approved_at' => $comment->approved_at ?? now()]);

        return redirect()->back();
    }
}

// special method name __invoke() allows a controller to be called like a function.
// a route can point directly to the controller class rather than specifying a method:
// Route::post(
//     'comments/{id}/approve',
//     ApproveCommentController::class);
