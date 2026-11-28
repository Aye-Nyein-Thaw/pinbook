<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::query()
            ->with(['user', 'trip'])

            // an admin sees the comments on all trips, others only on their own trips
            ->when(! auth()->user()->is_admin, function ($query) {
                $query->whereHas('trip', fn ($trip) => $trip->where('user_id', auth()->user()->id));
            })

            // /user/comments?unmoderated=1 shows only the comments waiting for approval
            ->when($request->boolean('unmoderated'), fn ($query) => $query->whereNull('approved_at'))
            ->orderByDesc('created_at')
            ->get();

        return view('userzone.comments.index', compact('comments'));
    }

    public function show(int $id)
    {
        $comment = Comment::findOrFail($id);

        abort_unless($comment->canManage(auth()->user()), 403);

        return view('userzone.comments.show', compact('comment'));
    }

    public function edit(int $id)
    {
        $comment = Comment::findOrFail($id);

        abort_unless($comment->canManage(auth()->user()), 403);

        return view('userzone.comments.edit', [
            'comment' => $comment,
            'approvalOptions' => $this->approvalOptions(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:3', 'max:1000'],
            'approved' => ['required', 'boolean'],
        ], [
            'content.min' => 'The comment needs at least 3 characters.',
            'approved.required' => 'Please choose approved or not approved.',
        ]);

        $comment = Comment::findOrFail($id);

        abort_unless($comment->canManage(auth()->user()), 403);

        $comment->update([
            'content' => $validated['content'],
            // keep the original approval date if it was already approved
            // if not approved, set it to null
            'approved_at' => $request->boolean('approved') ? ($comment->approved_at ?? now()) : null,
        ]);

        return redirect()->route('userzone.comments.index');
    }

    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);

        abort_unless($comment->canManage(auth()->user()), 403);

        $comment->delete();

        return redirect()->route('userzone.comments.index');
    }

    /**
     * @return array<int, array{key: int, value: string}>
     */
    private function approvalOptions(): array
    {
        return [
            ['key' => 1, 'value' => 'Approved'],
            ['key' => 0, 'value' => 'Not approved'],
        ];
    }
}
