<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarSchedule extends Model
{
    protected $table = "CarSchedules";

    protected $fillable = ['start', 'end'];

    public function car()
    {
        return $this->belongsTo(Car::class)->orderBy('created_at','asc');
    }
}
