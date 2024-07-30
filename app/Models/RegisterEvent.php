<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterEvent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function register_attendees() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
