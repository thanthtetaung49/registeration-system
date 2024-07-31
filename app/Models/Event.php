<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lead_instructors () {
        return $this->belongsTo(User::class, 'lead_instructors_id', 'id');
    }

    public function assists_instructors () {
        return $this->belongsTo(User::class, 'assist_instructors_id', 'id');
    }

    public function categories () {
        return $this->belongsTo(Category::class);
    }

    public function register_events() {
        
    }
}
