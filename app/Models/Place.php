<?php

namespace App\Models;

use Database\Factories\PlaceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /** @use HasFactory<PlaceFactory> */
    use HasFactory;

    protected $guarded = [];

    public function canManage($user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        // a place has no owner of its own: its trip's owner is its owner
        if ($this->trip->user_id == $user->id) {
            return true;
        }

        return false;
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
