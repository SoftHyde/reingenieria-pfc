<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Work extends Model
{
    use HasFactory;
	/**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 12;

    public function action(){
    	return $this->belongsTo(Action::class);
    }

    public function ratings(){
    	return $this->hasMany(Rating::class);
    }

}
