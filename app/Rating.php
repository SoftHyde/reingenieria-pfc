<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function work(){
    	return $this->belongsTo(Work::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
