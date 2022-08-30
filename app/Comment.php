<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;



    
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    protected $fillable = ['comment', 'proposal_id'];

    public function proposal(){
    	return $this->belongsTo(Proposal::class);	
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likers(){
        return $this->belongsToMany(User::class, 'user_like_comment')->withTimestamps();
    }

    public function responses(){
        return $this->hasMany(Comment::class, 'father_id');
    }

}
