<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'id',
        'name',
        'event_id',
        'summary',
        'description',
        'location',
        'startDateTime',
        'endDateTime',
        'organizer_email',
        'attendees',
    ];
}
