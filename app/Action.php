<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory;
	/**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 9;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actions';

    public function proposals(){

        return $this->hasMany(Proposal::class);
    }

    public function poll(){

        return $this->hasOne(Poll::class);
    }

    public function works(){

        return $this->hasMany(Work::class)->paginate();
    }

    public function newvents(){

        return $this->hasMany(Newvent::class)->paginate();
    }

    public function admin(){
        return $this->belongsTo(User::class);
    }
    public function actionTag(){
        return $this->hasMany(ActionTag::class);
    }
}
