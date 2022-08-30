<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function voters(){
    	return $this->belongsToMany(User::class, 'user_vote_option');
    }

    public function poll(){
    	return $this->belongsTo(Poll::class);
    }

    public function proposal(){
        return $this->belongsTo(Proposal::class);
    }
}
