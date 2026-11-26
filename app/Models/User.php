<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// For a login system, Laravel needs to know how to work with users who log in.
// Authenticatable provides the functionality Laravel's authentication system expects.

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // $fillable -->  fields that are allowed to be filled when we create or update a user using mass assignment.
    // $hidden -->  fields should be hidden when the User model is converted into an array or JSON.
    //              For example, when returning user data through an API, we don't want to expose the password.

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // $hidden controls which fields are hidden when the model is converted into an array or JSON. (serialization)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // type casting
        // Laravel automatically hashes the password before storing it in the database.
        // The database stores a hashed password, not the original plain text password.
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

// user -> trips() is a relationship method
// user -> trips    access related trips records

// $fillable and $guarded control mass assignment.
// $hidden controls what is included when the model is converted to an array or JSON.

// without $hidden, example:
// {
//     "id": 1,
//     "name": "Alice",
//     "email": "alice@example.com",
//     "password": "$2y$...",
//     "remember_token": "..."
// }

// with $hidden:
// {
//     "id": 1,
//     "name": "Alice",
//     "email": "alice@example.com"
// }
