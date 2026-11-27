<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

    // no attributes are blocked from mass assignment by $guarded.
    // So Laravel can accept fields such as title, destination, and user_id when the model is filled through mass assignment.
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function canManage($user): bool
    {
        // admin level user can manage comments
        if ($user->is_admin) {
            return true;
        }

        // the owner of the trip moderates the comments on it
        if ($this->trip->user_id == $user->id) {
            return true;
        }

        return false;
    }

    // who can view the comment
    public function canView($user): bool
    {
        // if comment is not approved yet, nobody can see it
        if ($this->approved_at !== null) {
            return true;
        }

        // $user is null for a guest -> guests cannot see comments (only logged-in users can see comments)
        if (! $user) {
            return false;
        }

        // the writer sees their own comment, even before it is approved
        if ($this->user_id == $user->id) {
            return true;
        }

        // if the user is not the comment author, Laravel checks whether they can manage the comment
        // trip owner or admin can see the comment
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

// $fillable — explicitly list the fields allowed.
// $guarded — list the fields that are blocked.
// This is a project-specific choice.
// It does not mean that every user should be allowed to submit every field;
// controllers and authorization checks still need to control what data is accepted.

// Mass Assignment - assigning multiple attributes to a model at once, usually by passing an array of data.
// $guarded, $fillable are different ways to control mass assignment.
// $guarded -> those fields a re blocked from mass assignment.

// About comments -> Who can see an unapproved comment?
// Person    Can see it?
// Guest.     No
// Commenter  Yes
// Trip owner Yes
// Admin      Yes
// Other logged-in user No

// canView() controls visibility.
// canManage() controls management permissions, such as approving or deleting a comment.
