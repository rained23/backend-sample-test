<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = "Cars";

    protected $casts = [
        'is_featured' => 'boolean',
        'location'=>'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function schedules()
    {
        return $this->hasMany(CarSchedule::class)->orderBy('created_at','desc');
    }

}
