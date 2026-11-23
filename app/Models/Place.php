<?php

namespace App\Models;

use Database\Factories\PlaceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Place extends Model implements HasMedia
{
    /** @use HasFactory<PlaceFactory> */
    use HasFactory;

    use InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        // a place has one photo: uploading a new one replaces the old one
        $this->addMediaCollection('photos')->singleFile();
    }

    public function getPhotoUrl(): string
    {
        if ($this->hasMedia('photos')) {
            return $this->getFirstMediaUrl('photos');
        }

        return '/img/default-place.png';
    }
}
