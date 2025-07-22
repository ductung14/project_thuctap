<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'start_at',
        'end_at',
        'status',
        'capacity'
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
            ->withPivot('registered_at')
            ->withTimestamps();
    }
}
