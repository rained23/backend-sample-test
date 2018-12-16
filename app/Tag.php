<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "Tags";

    protected $fillable = [ 'name' ];
    
    public function users()
    {        
        return $this->belongsToMany(User::class);
        
    }
}
