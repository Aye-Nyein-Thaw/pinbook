<?php

namespace App\Models;

use Database\Factories\TripFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /** @use HasFactory<TripFactory> */
    use HasFactory;

    // no field is blocked from mass assignment.
    protected $guarded = [];

    public function canManage($user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        if ($this->user_id == $user->id) {
            return true;
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The comments of this trip that the given user (or a guest: null) may see, newest first.
     */
    // retrieves comments that a particular user is allowed to see
    public function visibleCommentsFor($user)
    {
        return $this->comments()             // get all comments belonging to this trip
            ->with(['user', 'trip'])         // load related user and trip for the comment
            ->orderByDesc('created_at')      // order by newest comments
            ->get()
            ->filter(fn (Comment $comment) => $comment->canView($user));
        // checks each comment - Only comments for which canView($user) returns true remain in the collection
    }
}

// Logic for visibleCommentsFor($user)
//  - Retrieve comments for this Trip
//  - Sort newest first
//  - Check each comment with canView($user)
//  - Return only the comments this visitor may see
