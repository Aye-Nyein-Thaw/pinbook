<?php

namespace App\Models;

use Database\Factories\PlaceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /** @use HasFactory<PlaceFactory> */
    use HasFactory;

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
