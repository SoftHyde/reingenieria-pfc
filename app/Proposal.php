<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
	/**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 3;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proposals';

    protected $fillable = ['title', 'content', 'action_id'];

    public function action(){
        return $this->belongsTo(Action::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }

    public function supporters(){
        return $this->belongsToMany(User::class, 'user_support_proposal')->withTimestamps();
    }

    public function options(){

        return $this->hasMany(Option::class);
    }

    public function last_activity(){

        if( count($this->comments) > 0){
            return $this->comments()->orderBy('updated_at', 'desc')->first()->updated_at;    
        } else {
            return $this->updated_at;
        }
    }

}
