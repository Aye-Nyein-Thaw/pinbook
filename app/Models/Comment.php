<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function canManage($user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        // the owner of the trip moderates the comments on it
        if ($this->trip->user_id == $user->id) {
            return true;
        }

        return false;
    }

    public function canView($user): bool
    {
        if ($this->approved_at !== null) {
            return true;
        }

        // $user is null for a guest
        if (! $user) {
            return false;
        }

        // the writer sees their own comment, even before it is approved
        if ($this->user_id == $user->id) {
            return true;
        }

        return $this->canManage($user);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
