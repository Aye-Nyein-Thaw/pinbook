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

        abort_unless($comment->canManage(auth()->user()), 403);

        // approving twice keeps the first approval date
        $comment->update(['approved_at' => $comment->approved_at ?? now()]);

        return redirect()->back();
    }
}
