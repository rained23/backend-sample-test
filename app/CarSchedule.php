<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarSchedule extends Model
{
    protected $table = "CarSchedules";

    protected $fillable = ['car_id','start', 'end'];

    protected $dates = [
        'start','end'
    ];

    protected $cast = [
        'start'=>'datetime',
        'end'=>'datetime'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class)->orderBy('created_at','asc');
    }
}
