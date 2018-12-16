<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = "Cars";

    protected $casts = [
        'is_featured' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(CarSchedule::class)->orderBy('created_at','desc');
    }

}
