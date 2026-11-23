<?php

namespace App\Models;

use Database\Factories\TripFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /** @use HasFactory<TripFactory> */
    use HasFactory;

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
    public function visibleCommentsFor($user)
    {
        return $this->comments()
            ->with(['user', 'trip'])
            ->orderByDesc('created_at')
            ->get()
            ->filter(fn (Comment $comment) => $comment->canView($user));
    }
}
