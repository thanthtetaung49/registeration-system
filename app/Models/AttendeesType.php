<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeesType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'attendees_types_id', 'id');
    }

    public function register_events()
    {
        return $this->hasManyThrough(
            RegisterEvent::class,
            User::class,
            'attendees_types_id', // Foreign key on the users table...
            'users_id', // Foreign key on the register_events table...
            'id', // Local key on the attendees_types table...
            'id' // Local key on the users table...
        );
    }
}
