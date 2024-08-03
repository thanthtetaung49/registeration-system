<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterEvent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function register_attendees()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'events_id', 'id');
    }

    public function attendees_types()
    {
        // Through the user relationship
        return $this->hasOneThrough(
            AttendeesType::class,
            User::class,
            'id', // Foreign key on the users table...
            'id', // Foreign key on the attendees_types table...
            'users_id', // Local key on the register_events table...
            'attendees_types_id' // Local key on the users table...
        );
    }
}
